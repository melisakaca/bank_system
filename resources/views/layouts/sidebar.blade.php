<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 4C10.6008 3.99974 9.22593 4.36649 8.01273 5.06363C6.79952 5.76077 5.79038 6.76392 5.08603 7.97295C4.38168 9.18199 4.00675 10.5546 3.99868 11.9538C3.9906 13.3531 4.34966 14.7299 5.04001 15.947C5.50662 15.3406 6.10644 14.8496 6.7931 14.512C7.47975 14.1744 8.23485 13.9992 9.00001 14H15C15.7652 13.9992 16.5203 14.1744 17.2069 14.512C17.8936 14.8496 18.4934 15.3406 18.96 15.947C19.6504 14.7299 20.0094 13.3531 20.0013 11.9538C19.9933 10.5546 19.6183 9.18199 18.914 7.97295C18.2096 6.76392 17.2005 5.76077 15.9873 5.06363C14.7741 4.36649 13.3993 3.99974 12 4ZM19.943 18.076C21.28 16.333 22.0032 14.1968 22 12C22 6.477 17.523 2 12 2C6.47701 2 2.00001 6.477 2.00001 12C1.99671 14.1968 2.71992 16.333 4.05701 18.076L4.05201 18.094L4.40701 18.507C5.3449 19.6035 6.5094 20.4836 7.82024 21.0866C9.13109 21.6897 10.5571 22.0013 12 22C14.0273 22.0037 16.0074 21.3879 17.675 20.235C18.3859 19.7438 19.0306 19.163 19.593 18.507L19.948 18.094L19.943 18.076ZM12 6C11.2044 6 10.4413 6.31607 9.87869 6.87868C9.31608 7.44129 9.00001 8.20435 9.00001 9C9.00001 9.79565 9.31608 10.5587 9.87869 11.1213C10.4413 11.6839 11.2044 12 12 12C12.7957 12 13.5587 11.6839 14.1213 11.1213C14.6839 10.5587 15 9.79565 15 9C15 8.20435 14.6839 7.44129 14.1213 6.87868C13.5587 6.31607 12.7957 6 12 6Z"
                        fill="#666666" />
                </svg>
            </div>

            <div class="mt-3">

                <a href="#" class="text-body fw-medium font-size-16">{{ Auth::user()->name }}</a>
                <p class="text-muted mt-1 mb-0 font-size-13">{{ Auth::user()->role }}</p>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{ route('dashboard') }}" class=" waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span>Panel</span>
                    </a>


                </li>
              <!-- @if (Auth::user()->role === 'admin') -->
    

                <li>
                    <a href="javascript: void(0);" class="has-arrow  waves-effect">
                        <i class="mdi mdi-leaf"></i>
                        <span>Ferma</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('greenhouses.index') }}">Te gjitha Fermat</a>

                        </li>
                        <li><a href="{{ route('greenhouses.create') }}">Krijo Fermen</a>


                        </li>

                    </ul>

                </li>
                <!-- <
                @endif -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
