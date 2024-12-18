    <x-app-layout>
        
            
        

        

                <!-- Main Content -->
                <div class="col-md-9">
                    <!-- Profile Information Update Form -->
                    <div class="bg-white shadow rounded mb-4 p-4">
                        <div class="container">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Password Update Form -->
                    <div class="bg-white shadow rounded mb-4 p-4">
                        <div class="container">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <!-- Delete User Form -->
                    <div class="bg-white shadow rounded p-4">
                        <div class="container">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
