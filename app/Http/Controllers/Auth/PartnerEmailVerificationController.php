<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartnerEmailVerificationController extends Controller
{
    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/partner/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectTo);
        }

        return view('auth.partner.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (!hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (!hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectTo);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

            // Update partner status to active if this is a partner
            if ($request->user()->role === 'partner') {
                $this->activatePartner($request->user());
            }
        }

        return redirect($this->redirectTo)->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectTo);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    /**
     * Activate the partner account after email verification.
     *
     * @param User $user
     * @return void
     */
    protected function activatePartner(User $user)
    {
        try {
            $partner = Partner::where('user_id', $user->id)->first();
            
            if ($partner) {
                $partner->update(['status' => 'active']);
                Log::info('Partner account activated after email verification', [
                    'user_id' => $user->id,
                    'partner_id' => $partner->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to activate partner account after email verification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
