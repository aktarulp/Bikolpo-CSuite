@extends('layouts.partner-layout')

@section('title', 'Typing Tutorial')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Bikolpo Typing Tutorial</h1>
            <p class="text-xl text-gray-600">Master the fundamentals of touch typing</p>
        </div>

        <!-- Navigation Breadcrumb -->
        <div class="mb-8">
            <a href="{{ route('typing.test') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Typing Test
            </a>
        </div>

        <!-- Tutorial Sections -->
        <div class="space-y-8">
            <!-- Section 1: Home Row Position -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Home Row Position</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <p class="text-gray-700 text-lg mb-4">
                            The foundation of touch typing is the home row position. Place your fingers on the home row keys:
                        </p>
                        <div class="bg-gray-50 rounded-lg p-6 mb-4">
                            <div class="text-center font-mono text-2xl font-bold text-gray-800 mb-2">
                                A S D F  |  J K L ;
                            </div>
                            <div class="text-center text-sm text-gray-600">
                                Left Hand | Right Hand
                            </div>
                        </div>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Left index finger on <strong>F</strong>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Right index finger on <strong>J</strong>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Other fingers naturally fall into place
                            </li>
                        </ul>
                    </div>
                    
                                         <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6">
                         <h3 class="font-semibold text-blue-900 mb-3">Practice Exercise</h3>
                         <div class="bg-white rounded-lg p-4 mb-4">
                             <div class="text-center font-mono text-lg text-gray-800 mb-2" id="practiceText">
                                 asdf jkl;
                             </div>
                             <div class="text-center text-sm text-gray-600">
                                 Type this 10 times to get comfortable
                             </div>
                         </div>
                         <div class="text-center">
                             <button id="startPracticeBtn" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                 Start Practice
                             </button>
                         </div>
                     </div>
                </div>
            </div>

            <!-- Section 2: Finger Placement -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Finger Placement & Movement</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Left Hand</h3>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-red-200 rounded-full flex items-center justify-center mr-3 text-sm font-bold">A</div>
                                <span class="text-gray-700">Pinky finger</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center mr-3 text-sm font-bold">S</div>
                                <span class="text-gray-700">Ring finger</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-yellow-200 rounded-full flex items-center justify-center mr-3 text-sm font-bold">D</div>
                                <span class="text-gray-700">Middle finger</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center mr-3 text-sm font-bold">F</div>
                                <span class="text-gray-700">Index finger</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Right Hand</h3>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center mr-3 text-sm font-bold">J</div>
                                <span class="text-gray-700">Index finger</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-yellow-200 rounded-full flex items-center justify-center mr-3 text-sm font-bold">K</div>
                                <span class="text-gray-700">Middle finger</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center mr-3 text-sm font-bold">L</div>
                                <span class="text-gray-700">Ring finger</span>
                            </div>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-red-200 rounded-full flex items-center justify-center mr-3 text-sm font-bold">;</div>
                                <span class="text-gray-700">Pinky finger</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Common Words Practice -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl font-bold text-purple-600">3</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Common Words Practice</h2>
                </div>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6">
                        <h3 class="font-semibold text-purple-900 mb-3">Home Row Words</h3>
                        <div class="space-y-2 text-sm">
                            <div class="bg-white rounded p-2 text-center font-mono">as</div>
                            <div class="bg-white rounded p-2 text-center font-mono">sad</div>
                            <div class="bg-white rounded p-2 text-center font-mono">dad</div>
                            <div class="bg-white rounded p-2 text-center font-mono">fad</div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6">
                        <h3 class="font-semibold text-green-900 mb-3">Common Combinations</h3>
                        <div class="space-y-2 text-sm">
                            <div class="bg-white rounded p-2 text-center font-mono">the</div>
                            <div class="bg-white rounded p-2 text-center font-mono">and</div>
                            <div class="bg-white rounded p-2 text-center font-mono">for</div>
                            <div class="bg-white rounded p-2 text-center font-mono">you</div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6">
                        <h3 class="font-semibold text-blue-900 mb-3">Short Sentences</h3>
                        <div class="space-y-2 text-sm">
                            <div class="bg-white rounded p-2 text-center">I am here.</div>
                            <div class="bg-white rounded p-2 text-center">We can do it.</div>
                            <div class="bg-white rounded p-2 text-center">The cat sat.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Speed Building -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl font-bold text-orange-600">4</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Speed Building Techniques</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Progressive Practice</h3>
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg">
                                <div class="w-10 h-10 bg-orange-200 rounded-full flex items-center justify-center mr-4 text-sm font-bold">1</div>
                                <div>
                                    <div class="font-semibold text-orange-900">Start Slow</div>
                                    <div class="text-sm text-orange-700">Focus on accuracy over speed</div>
                                </div>
                            </div>
                            <div class="flex items-center p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg">
                                <div class="w-10 h-10 bg-yellow-200 rounded-full flex items-center justify-center mr-4 text-sm font-bold">2</div>
                                <div>
                                    <div class="font-semibold text-yellow-900">Build Consistency</div>
                                    <div class="text-sm text-yellow-700">Practice daily for 15-30 minutes</div>
                                </div>
                            </div>
                            <div class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg">
                                <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center mr-4 text-sm font-bold">3</div>
                                <div>
                                    <div class="font-semibold text-green-900">Increase Speed</div>
                                    <div class="text-sm text-green-700">Gradually increase tempo while maintaining accuracy</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6">
                        <h3 class="font-semibold text-orange-900 mb-4">Speed Goals</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center bg-white rounded-lg p-3">
                                <span class="text-orange-800">Beginner</span>
                                <span class="font-bold text-orange-900">20-30 WPM</span>
                            </div>
                            <div class="flex justify-between items-center bg-white rounded-lg p-3">
                                <span class="text-orange-800">Intermediate</span>
                                <span class="font-bold text-orange-900">40-60 WPM</span>
                            </div>
                            <div class="flex justify-between items-center bg-white rounded-lg p-3">
                                <span class="text-orange-800">Advanced</span>
                                <span class="font-bold text-orange-900">70+ WPM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: Common Mistakes & Tips -->
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-2xl font-bold text-red-600">5</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Common Mistakes & Tips</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-red-800 mb-4">❌ Avoid These Mistakes</h3>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Looking at the keyboard while typing
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Using only index fingers
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Hitting keys too hard
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Not returning to home row position
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-green-800 mb-4">✅ Pro Tips</h3>
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Keep your eyes on the screen
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Use all fingers for typing
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Light, gentle keystrokes
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Always return to home row
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

                         <!-- Practice Mode Section -->
             <div id="practiceMode" class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hidden">
                 <div class="text-center mb-6">
                     <h2 class="text-3xl font-bold text-gray-900 mb-2">Practice Mode</h2>
                     <p class="text-gray-600">Focus on the home row keys and build your muscle memory</p>
                 </div>
                 
                 <div class="max-w-4xl mx-auto">
                     <!-- Practice Stats -->
                     <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                         <div class="bg-blue-50 rounded-lg p-4 text-center">
                             <div class="text-2xl font-bold text-blue-600" id="practiceCount">0</div>
                             <div class="text-sm text-blue-700">Repetitions</div>
                         </div>
                         <div class="bg-green-50 rounded-lg p-4 text-center">
                             <div class="text-2xl font-bold text-green-600" id="practiceAccuracy">100%</div>
                             <div class="text-sm text-green-700">Accuracy</div>
                         </div>
                         <div class="bg-purple-50 rounded-lg p-4 text-center">
                             <div class="text-2xl font-bold text-purple-600" id="practiceTimer">00:00</div>
                             <div class="text-sm text-purple-700">Time</div>
                         </div>
                     </div>
                     
                                           <!-- Practice Area -->
                      <div class="bg-gray-50 rounded-xl p-6 mb-6">
                          <div class="text-center mb-4">
                              <div class="text-lg text-gray-600 mb-2">Type this text:</div>
                              <div class="text-3xl font-mono font-bold text-gray-800 bg-white rounded-lg p-4 border-2 border-blue-200" id="targetText">
                                  asdf jkl;
                              </div>
                          </div>
                          
                          <div class="text-center">
                              <textarea 
                                  id="practiceInput" 
                                  class="w-full h-24 p-4 text-lg font-mono border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 resize-none"
                                  placeholder="Start typing here..."
                                  disabled
                              ></textarea>
                          </div>
                          
                          <div class="text-center mt-4">
                              <button id="resetPracticeBtn" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors mr-2">
                                  Reset
                              </button>
                              <button id="stopPracticeBtn" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                  Stop Practice
                              </button>
                          </div>
                      </div>
                      
                      <!-- Interactive Keyboard -->
                      <div class="bg-white rounded-xl p-6 border border-gray-200">
                          <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Keyboard Layout</h3>
                          <div class="keyboard-container overflow-x-auto">
                              <div class="keyboard" id="keyboard">
                                  <!-- Row 1: Numbers -->
                                  <div class="keyboard-row">
                                      <div class="key" data-key="`">`</div>
                                      <div class="key" data-key="1">1</div>
                                      <div class="key" data-key="2">2</div>
                                      <div class="key" data-key="3">3</div>
                                      <div class="key" data-key="4">4</div>
                                      <div class="key" data-key="5">5</div>
                                      <div class="key" data-key="6">6</div>
                                      <div class="key" data-key="7">7</div>
                                      <div class="key" data-key="8">8</div>
                                      <div class="key" data-key="9">9</div>
                                      <div class="key" data-key="0">0</div>
                                      <div class="key" data-key="-">-</div>
                                      <div class="key" data-key="=">=</div>
                                      <div class="key key-backspace" data-key="Backspace">⌫</div>
                                  </div>
                                  
                                  <!-- Row 2: QWERTY -->
                                  <div class="keyboard-row">
                                      <div class="key key-tab" data-key="Tab">Tab</div>
                                      <div class="key" data-key="q">Q</div>
                                      <div class="key" data-key="w">W</div>
                                      <div class="key" data-key="e">E</div>
                                      <div class="key" data-key="r">R</div>
                                      <div class="key" data-key="t">T</div>
                                      <div class="key" data-key="y">Y</div>
                                      <div class="key" data-key="u">U</div>
                                      <div class="key" data-key="i">I</div>
                                      <div class="key" data-key="o">O</div>
                                      <div class="key" data-key="p">P</div>
                                      <div class="key" data-key="[">[</div>
                                      <div class="key" data-key="]">]</div>
                                      <div class="key" data-key="\\">\</div>
                                  </div>
                                  
                                  <!-- Row 3: ASDF -->
                                  <div class="keyboard-row">
                                      <div class="key key-caps" data-key="CapsLock">Caps</div>
                                      <div class="key key-home" data-key="a">A</div>
                                      <div class="key key-home" data-key="s">S</div>
                                      <div class="key key-home" data-key="d">D</div>
                                      <div class="key key-home" data-key="f">F</div>
                                      <div class="key" data-key="g">G</div>
                                      <div class="key" data-key="h">H</div>
                                      <div class="key key-home" data-key="j">J</div>
                                      <div class="key key-home" data-key="k">K</div>
                                      <div class="key key-home" data-key="l">L</div>
                                      <div class="key key-home" data-key=";">;</div>
                                      <div class="key" data-key="'">'</div>
                                      <div class="key key-enter" data-key="Enter">↵</div>
                                  </div>
                                  
                                  <!-- Row 4: ZXCV -->
                                  <div class="keyboard-row">
                                      <div class="key key-shift" data-key="Shift">⇧</div>
                                      <div class="key" data-key="z">Z</div>
                                      <div class="key" data-key="x">X</div>
                                      <div class="key" data-key="c">C</div>
                                      <div class="key" data-key="v">V</div>
                                      <div class="key" data-key="b">B</div>
                                      <div class="key" data-key="n">N</div>
                                      <div class="key" data-key="m">M</div>
                                      <div class="key" data-key=",">,</div>
                                      <div class="key" data-key=".">.</div>
                                      <div class="key" data-key="/">/</div>
                                      <div class="key key-shift" data-key="ShiftRight">⇧</div>
                                  </div>
                                  
                                  <!-- Row 5: Space -->
                                  <div class="keyboard-row">
                                      <div class="key key-ctrl" data-key="Control">Ctrl</div>
                                      <div class="key key-win" data-key="Meta">⊞</div>
                                      <div class="key key-alt" data-key="Alt">Alt</div>
                                      <div class="key key-space" data-key=" ">Space</div>
                                      <div class="key key-alt" data-key="AltRight">Alt</div>
                                      <div class="key key-win" data-key="MetaRight">⊞</div>
                                      <div class="key key-menu" data-key="ContextMenu">☰</div>
                                      <div class="key key-ctrl" data-key="ControlRight">Ctrl</div>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Keyboard Legend -->
                          <div class="mt-4 text-center text-sm text-gray-600">
                              <div class="flex justify-center space-x-4">
                                  <div class="flex items-center">
                                      <div class="w-4 h-4 bg-blue-200 rounded mr-2"></div>
                                      <span>Home Row Keys</span>
                                  </div>
                                  <div class="flex items-center">
                                      <div class="w-4 h-4 bg-green-200 rounded mr-2"></div>
                                      <span>Pressed</span>
                                  </div>
                                  <div class="flex items-center">
                                      <div class="w-4 h-4 bg-red-200 rounded mr-2"></div>
                                      <span>Wrong Key</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                     
                     <!-- Progress Bar -->
                     <div class="mb-6">
                         <div class="flex justify-between text-sm text-gray-600 mb-2">
                             <span>Progress</span>
                             <span id="progressText">0/10</span>
                         </div>
                         <div class="w-full bg-gray-200 rounded-full h-3">
                             <div id="progressBar" class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                         </div>
                     </div>
                 </div>
             </div>

             <!-- Call to Action -->
             <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-center text-white">
                 <h2 class="text-3xl font-bold mb-4">Ready to Practice?</h2>
                 <p class="text-xl text-blue-100 mb-6">Now that you've learned the basics, put your skills to the test!</p>
                 <div class="flex flex-col sm:flex-row gap-4 justify-center">
                     <a href="{{ route('typing.test') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                         Take Typing Test
                     </a>
                     <button id="practiceMoreBtn" class="bg-white/20 text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/30 transition-colors border border-white/30">
                         Practice More
                     </button>
                 </div>
             </div>
        </div>
    </div>
</div>

<style>
/* Keyboard Styles */
.keyboard-container {
    max-width: 100%;
    margin: 0 auto;
}

.keyboard {
    display: inline-block;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.keyboard-row {
    display: flex;
    margin-bottom: 8px;
    justify-content: center;
}

.keyboard-row:last-child {
    margin-bottom: 0;
}

.key {
    width: 40px;
    height: 40px;
    margin: 0 2px;
    background: #ffffff;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    cursor: default;
    transition: all 0.15s ease;
    position: relative;
    user-select: none;
}

.key:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.key.key-home {
    background: #dbeafe;
    border-color: #93c5fd;
    color: #1e40af;
}

.key.key-pressed {
    background: #dcfce7;
    border-color: #86efac;
    color: #166534;
    transform: translateY(2px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.key.key-wrong {
    background: #fecaca;
    border-color: #f87171;
    color: #dc2626;
    animation: shake 0.3s ease-in-out;
}

.key.key-wrong::after {
    content: '✗';
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc2626;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}

.key.key-tab,
.key.key-caps,
.key.key-shift,
.key.key-enter,
.key.key-backspace {
    width: 60px;
    font-size: 10px;
}

.key.key-space {
    width: 200px;
}

.key.key-ctrl,
.key.key-alt,
.key.key-win,
.key.key-menu {
    width: 50px;
    font-size: 10px;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-2px); }
    75% { transform: translateX(2px); }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .key {
        width: 32px;
        height: 32px;
        font-size: 10px;
        margin: 0 1px;
    }
    
    .key.key-tab,
    .key.key-caps,
    .key.key-shift,
    .key.key-enter,
    .key.key-backspace {
        width: 48px;
        font-size: 8px;
    }
    
    .key.key-space {
        width: 160px;
    }
    
    .keyboard {
        padding: 15px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Practice mode variables
    let practiceActive = false;
    let practiceTimer = null;
    let startTime = null;
    let currentRepetition = 0;
    let totalRepetitions = 10;
    let correctCharacters = 0;
    let totalCharacters = 0;
    let wrongKeys = new Set();
    let buzzerAudio = null;
    
    // DOM elements
    const practiceMode = document.getElementById('practiceMode');
    const startPracticeBtn = document.getElementById('startPracticeBtn');
    const practiceInput = document.getElementById('practiceInput');
    const targetText = document.getElementById('targetText');
    const resetPracticeBtn = document.getElementById('resetPracticeBtn');
    const stopPracticeBtn = document.getElementById('stopPracticeBtn');
    const practiceMoreBtn = document.getElementById('practiceMoreBtn');
    const practiceCount = document.getElementById('practiceCount');
    const practiceAccuracy = document.getElementById('practiceAccuracy');
    const practiceTimerDisplay = document.getElementById('practiceTimer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    // Practice exercises
    const practiceExercises = [
        'asdf jkl;',
        'asdf jkl; asdf jkl;',
        'asdf jkl; asdf jkl; asdf jkl;',
        'the quick brown fox',
        'jumps over the lazy dog',
        'pack my box with five dozen',
        'liquor jugs',
        'how vexingly quick daft zebras jump',
        'the five boxing wizards',
        'jump quickly'
    ];
    
    // Initialize buzzer sound
    function initBuzzer() {
        try {
            // Create audio context for buzzer sound
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
            oscillator.type = 'square';
            
            gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
        } catch (error) {
            console.log('Audio not supported, using fallback');
        }
    }
    
    // Play buzzer sound
    function playBuzzer() {
        initBuzzer();
    }
    
    // Keyboard functions
    function highlightKey(key) {
        const keyElement = document.querySelector(`[data-key="${key}"]`);
        if (keyElement) {
            keyElement.classList.add('key-pressed');
            setTimeout(() => {
                keyElement.classList.remove('key-pressed');
            }, 150);
        }
    }
    
    function markWrongKey(key) {
        const keyElement = document.querySelector(`[data-key="${key}"]`);
        if (keyElement && !wrongKeys.has(key)) {
            wrongKeys.add(key);
            keyElement.classList.add('key-wrong');
            playBuzzer();
            
            // Remove wrong mark after 2 seconds
            setTimeout(() => {
                keyElement.classList.remove('key-wrong');
            }, 2000);
        }
    }
    
    function resetKeyboard() {
        // Remove all visual states
        document.querySelectorAll('.key').forEach(key => {
            key.classList.remove('key-pressed', 'key-wrong');
        });
        wrongKeys.clear();
    }
    
    // Start practice mode
    startPracticeBtn.addEventListener('click', function() {
        practiceMode.classList.remove('hidden');
        practiceMode.scrollIntoView({ behavior: 'smooth' });
        startPractice();
    });
    
    // Start practice session
    function startPractice() {
        practiceActive = true;
        currentRepetition = 0;
        correctCharacters = 0;
        totalCharacters = 0;
        startTime = Date.now();
        
        // Update UI
        startPracticeBtn.disabled = true;
        startPracticeBtn.textContent = 'Practice Active';
        startPracticeBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        startPracticeBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        
        // Enable input
        practiceInput.disabled = false;
        practiceInput.focus();
        
        // Start timer
        startTimer();
        
        // Load first exercise
        loadNextExercise();
        
        // Update progress
        updateProgress();
    }
    
    // Load next exercise
    function loadNextExercise() {
        if (currentRepetition < totalRepetitions) {
            const exercise = practiceExercises[currentRepetition % practiceExercises.length];
            targetText.textContent = exercise;
            practiceInput.value = '';
            practiceInput.placeholder = 'Type: ' + exercise;
        }
    }
    
    // Start timer
    function startTimer() {
        practiceTimer = setInterval(() => {
            if (startTime) {
                const elapsed = Date.now() - startTime;
                const minutes = Math.floor(elapsed / 60000);
                const seconds = Math.floor((elapsed % 60000) / 1000);
                practiceTimerDisplay.textContent = 
                    (minutes < 10 ? '0' : '') + minutes + ':' + 
                    (seconds < 10 ? '0' : '') + seconds;
            }
        }, 1000);
    }
    
    // Update progress
    function updateProgress() {
        const progress = (currentRepetition / totalRepetitions) * 100;
        progressBar.style.width = progress + '%';
        progressText.textContent = currentRepetition + '/' + totalRepetitions;
        practiceCount.textContent = currentRepetition;
    }
    
    // Handle typing input
    practiceInput.addEventListener('input', function() {
        if (!practiceActive) return;
        
        const target = targetText.textContent;
        const typed = this.value;
        
        // Check if current repetition is complete
        if (typed === target) {
            currentRepetition++;
            correctCharacters += target.length;
            totalCharacters += target.length;
            
            // Update accuracy
            const accuracy = Math.round((correctCharacters / totalCharacters) * 100);
            practiceAccuracy.textContent = accuracy + '%';
            
            // Update progress
            updateProgress();
            
            // Check if practice is complete
            if (currentRepetition >= totalRepetitions) {
                completePractice();
                return;
            }
            
            // Load next exercise
            setTimeout(() => {
                loadNextExercise();
            }, 500);
        } else {
            // Update accuracy in real-time
            let correct = 0;
            for (let i = 0; i < Math.min(typed.length, target.length); i++) {
                if (typed[i] === target[i]) correct++;
            }
            totalCharacters = Math.max(typed.length, target.length);
            const accuracy = Math.round((correct / totalCharacters) * 100);
            practiceAccuracy.textContent = accuracy + '%';
        }
    });
    
    // Handle keydown events for keyboard visualization
    practiceInput.addEventListener('keydown', function(e) {
        if (!practiceActive) return;
        
        const key = e.key;
        const target = targetText.textContent;
        const typed = this.value;
        const currentIndex = typed.length;
        
        // Highlight the pressed key
        highlightKey(key);
        
        // Check if the key is wrong
        if (currentIndex < target.length) {
            const expectedKey = target[currentIndex];
            if (key !== expectedKey) {
                markWrongKey(key);
            }
        }
    });
    
    // Complete practice
    function completePractice() {
        practiceActive = false;
        clearInterval(practiceTimer);
        
        // Show completion message
        const timeSpent = practiceTimerDisplay.textContent;
        const finalAccuracy = practiceAccuracy.textContent;
        
        alert(`🎉 Practice Complete!\n\nRepetitions: ${currentRepetition}\nTime: ${timeSpent}\nAccuracy: ${finalAccuracy}\n\nGreat job! Keep practicing to improve your typing skills.`);
        
        // Reset UI
        resetPractice();
    }
    
    // Reset practice
    function resetPractice() {
        practiceActive = false;
        clearInterval(practiceTimer);
        
        // Reset variables
        currentRepetition = 0;
        correctCharacters = 0;
        totalCharacters = 0;
        startTime = null;
        
        // Reset UI
        startPracticeBtn.disabled = false;
        startPracticeBtn.textContent = 'Start Practice';
        startPracticeBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
        startPracticeBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
        
        practiceInput.disabled = true;
        practiceInput.value = '';
        practiceInput.placeholder = 'Start typing here...';
        
        practiceTimerDisplay.textContent = '00:00';
        practiceAccuracy.textContent = '100%';
        practiceCount.textContent = '0';
        progressBar.style.width = '0%';
        progressText.textContent = '0/' + totalRepetitions;
        
        targetText.textContent = 'asdf jkl;';
        
        // Reset keyboard
        resetKeyboard();
    }
    
    // Reset button
    resetPracticeBtn.addEventListener('click', resetPractice);
    
    // Stop practice button
    stopPracticeBtn.addEventListener('click', function() {
        if (practiceActive) {
            if (confirm('Are you sure you want to stop the practice session?')) {
                practiceActive = false;
                clearInterval(practiceTimer);
                resetPractice();
            }
        }
    });
    
    // Practice more button
    practiceMoreBtn.addEventListener('click', function() {
        if (practiceMode.classList.contains('hidden')) {
            practiceMode.classList.remove('hidden');
            practiceMode.scrollIntoView({ behavior: 'smooth' });
        }
        startPractice();
    });
    
    // Add smooth scrolling for better UX
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
</script>
@endsection
