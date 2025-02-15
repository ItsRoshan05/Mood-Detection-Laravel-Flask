<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard link, visible to all users -->
        <li class="nav-item">
            <a class="nav-link" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- Menu for all users -->
        <li class="nav-heading">Sentiment</li>
        <li class="nav-item">
            <a class="nav-link" href="/sentiment">
                <i class="bi bi-gear"></i>
                <span>Prediksi</span>
            </a>
        </li>

        <!-- Menu for Admin and Superadmin -->
        @if (Auth::check() && (Auth::user()->kategori === 'admin'))
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Master Tables</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="/users">
                            <i class="bi bi-circle"></i><span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="/predictions">
                            <i class="bi bi-circle"></i><span>Data Prediksi</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Tables Nav -->
        @endif

    </ul>

</aside><!-- End Sidebar -->
