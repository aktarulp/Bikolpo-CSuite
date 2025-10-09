<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        // Get all public routes
        $routes = Route::getRoutes();
        $urls = [];

        // Define which routes to include in sitemap
        $allowedRoutes = [
            'landing',
            'register',
            'login',
            'password.request',
            'about',
            'contact',
            'partner.features',
            'student.features',
            'privacy',
            'terms',
            'cookies',
        ];

        foreach ($routes as $route) {
            // Skip routes with parameters (dynamic routes)
            if (strpos($route->uri(), '{') !== false) {
                continue;
            }

            // Skip auth routes that require authentication
            if ($this->requiresAuth($route)) {
                continue;
            }

            // Check if route should be included
            if ($this->shouldIncludeRoute($route, $allowedRoutes)) {
                $urls[] = [
                    'loc' => url($route->uri()),
                    'lastmod' => now()->toDateString(),
                    'changefreq' => $this->getChangeFrequency($route->getName()),
                    'priority' => $this->getPriority($route->getName()),
                ];
            }
        }

        // Sort URLs by priority (highest first)
        usort($urls, function($a, $b) {
            return $b['priority'] <=> $a['priority'];
        });

        // Return the sitemap as XML
        $content = view('sitemap', compact('urls'))->render();
        return Response::make($content, 200, ['Content-Type' => 'application/xml']);
    }

    private function requiresAuth($route)
    {
        $middleware = $route->middleware();
        return in_array('auth', $middleware) || in_array('verified', $middleware);
    }

    private function shouldIncludeRoute($route, $allowedRoutes)
    {
        $routeName = $route->getName();
        
        // Include named routes that are in our allowed list
        if ($routeName && in_array($routeName, $allowedRoutes)) {
            return true;
        }

        // Include routes without names that are common public pages
        $publicUris = ['', 'about', 'contact', 'privacy', 'terms', 'cookies'];
        if (in_array($route->uri(), $publicUris)) {
            return true;
        }

        return false;
    }

    private function getChangeFrequency($routeName)
    {
        $changefreqMap = [
            'landing' => 'weekly',
            'register' => 'monthly',
            'login' => 'monthly',
            'password.request' => 'monthly',
            'about' => 'monthly',
            'contact' => 'monthly',
            'partner.features' => 'monthly',
            'student.features' => 'monthly',
            'privacy' => 'yearly',
            'terms' => 'yearly',
            'cookies' => 'yearly',
        ];

        return $changefreqMap[$routeName] ?? 'monthly';
    }

    private function getPriority($routeName)
    {
        $priorityMap = [
            'landing' => '1.0',
            'register' => '0.8',
            'login' => '0.8',
            'password.request' => '0.7',
            'about' => '0.7',
            'contact' => '0.7',
            'partner.features' => '0.7',
            'student.features' => '0.7',
            'privacy' => '0.5',
            'terms' => '0.5',
            'cookies' => '0.5',
        ];

        return $priorityMap[$routeName] ?? '0.5';
    }
}