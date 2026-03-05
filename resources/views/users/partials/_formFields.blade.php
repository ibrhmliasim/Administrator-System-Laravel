
<!-- C:\Users\Asim\sekkeiShoLrvl\resources\views\users\partials\_formFields.blade.php -->
<!-- ユーザーが入力するフォームフィールド -->

    <!-- グループ１ -->
        <div class="space-y-8 text-gray-700 text-lg font-medium">
            <!-- ログインID -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="login_id" class="text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    ログインID (必須):
                </label>

                <div class="w-full max-w-md">
                    <input type="text" name="login_id" id="login_id" 
                        value="{{ old('login_id', $user->login_id ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('login_id') border-red-500 @enderror">
                    
                    @error('login_id')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- パスワード -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="password" class=" text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    パスワード (必須):
                </label>

                <div class="w-full max-w-md">
                    <input type="password" name="password" id="password" 
                        value="{{ old('password') }}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('password') border-red-500 @enderror">
                    
                    @error('password')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- 氏名 -->
            <div class="flex flex-col sm:flex-row sm:gap-10 sm:items-start">
                <div class="text-red-700 mb-2 sm:mb-0 sm:w-52 sm:shrink-0 pt-2"> 氏名 (必須): </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:gap-4 grow max-w-md"> 
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2 grow">
                        <label for="user_surname" class="  text-gray-700 mb-1 sm:mb-0 sm:shrink-0">
                            姓:
                        </label>
                        
                        <div class="w-full">
                            <input type="text" name="user_surname" id="user_surname" value="{{ old('user_surname', $user->user_surname ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('user_surname') border-red-500 @enderror">
                            @error('user_surname') 
                                <div class="text-red-500 text-sm leading-tight mt-2">{{ $message }}</div> 
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2 grow">
                        <label for="user_name" class="  text-gray-700 mb-1 sm:mb-0 sm:shrink-0">
                            名:
                        </label>

                        <div class="w-full">
                            <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $user->user_name ?? '') }}"
                                class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('user_name') border-red-500 @enderror">
                            @error('user_name') 
                                <div class="text-red-500 text-sm leading-tight mt-2">{{ $message }}</div> 
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- グループ２ -->
        <div class="space-y-6 text-gray-700 text-lg font-medium">
            <!-- 郵便番号 -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="postal_cd" class="text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    郵便番号 (必須):
                </label>

                <div class="w-full max-w-md">
                    <input type="text" name="postal_cd" id="postal_cd"
                        placeholder="例: 1000001 (ハイフン不要)" 
                        value="{{ old('postal_cd', $user->postal_cd ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('postal_cd') border-red-500 @enderror">
                    
                    @error('postal_cd')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 都道府県 -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="prefectures" class="text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    都道府県 (必須):
                </label>

                <div class="w-full max-w-md">
                    <select name="prefectures" id="prefectures" 
                        class="w-full px-2 py-2 border border-gray-400 rounded-sm shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 @error('prefectures') border-red-500 @enderror">
                        
                        <option value="">選択してください</option>

                        @foreach(config('prefectures.prefectures') as $pref)
                            <option value="{{ $pref }}" 
                                {{ old('prefectures', $user->prefectures ?? '') == $pref ? 'selected' : '' }}>
                                {{ $pref }}
                            </option>
                        @endforeach
                    </select>
                    
                    @error('prefectures')
                        <div class="text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 市区町村 -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="city" class="text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    市区町村 (必須):
                </label>

                <div class="w-full max-w-md">
                    <input type="text" name="city" id="city" 
                        value="{{ old('city', $user->city ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('city') border-red-500 @enderror">
                    
                    @error('city')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 番地  -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="address" class="text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    番地 (必須):
                </label>

                <div class="w-full max-w-md">
                    <input type="text" name="address" id="address" 
                        value="{{ old('address', $user->address ?? '')}}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('address') border-red-500 @enderror">
                    
                    @error('address')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 建造物名等 -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="other_address" class="text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    建造物名等 (必須):
                </label>

                <div class="w-full max-w-md">
                    <input type="text" name="other_address" id="other_address" 
                        value="{{ old('other_address', $user->other_address ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('other_address') border-red-500 @enderror">
                    
                    @error('other_address')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 生年月日 -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="birthday" class="text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    生年月日 (必須):
                </label>

                <div class="w-full max-w-md">
                    <input type="text" name="birthday" id="birthday"
                        placeholder="例: 1990/12/02"  
                        value="{{ old('birthday', isset($user->birthday) ? $user->birthday->format('Y/m/d') : '') }}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('birthday') border-red-500 @enderror">
                    
                    @error('birthday')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 性別 -->
            <div class="md:flex lg:flex items-center sm:items-center gap-2 lg:gap-11">
                <span  class="text-red-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">性別 (必須):</span>
                
                <div class="flex flex-row justify-center md:justify-start gap-[1.8rem] md:gap-[0.44rem] lg:gap-[1.6rem] grow py-1">
                    @foreach(config('user.gender') as $value => $label)
                        @if($value === '') @continue @endif

                        <label class="flex items-center text-gray-700 cursor-pointer font-medium">
                            <input type="radio"
                                name="gender"
                                value="{{ (string)$value }}"
                                {{-- old('gender', '0'): --}}
                                {{ old('gender', (string)($user->gender ?? '0')) === (string)$value ? 'checked' : '' }}
                                class="mr-1">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- メールアドレス -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="email" class="text-gray-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    メールアドレス:
                </label>

                <div class="w-full max-w-md">
                    <input type="text" name="email" id="email" 
                        value="{{ old('email', $user->email ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('email') border-red-500 @enderror">
                    
                    @error('email')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 電話番号 -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-10">
                <label for="tel" class="text-gray-700 mb-1 sm:mb-0 sm:w-52 sm:shrink-0">
                    電話番号:
                </label>

                <div class="w-full max-w-md">
                    <input type="text" name="tel" id="tel" 
                        value="{{ old('tel', $user->tel ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-400 rounded-sm shadow-sm @error('tel') border-red-500 @enderror">
                    
                    @error('tel')
                        <div class=" text-red-500 text-sm leading-tight mt-2" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>