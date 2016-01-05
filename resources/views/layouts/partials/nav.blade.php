<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Laundry</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              @if (Auth::user()->role_id == 3)
              <li class="{{ (Request::is('admin/user') ? 'active' : '') }}">
                  <a href="{!! route('admin.user') !!}"><i class="fa fa-book"></i>Pegawai</a>
              </li>
              @endif
                <li class="{{ (Request::is('admin/customer') ? 'active' : '') }}">
                    <a href="{!! route('admin.customer') !!}"><i class="fa fa-book"></i>Pelanggan</a>
                </li>
                <li class="{{ (Request::is('admin/package') ? 'active' : '') }}">
                    <a href="{!! route('admin.package') !!}"><i class="fa fa-book"></i>Paket Layanan</a>
                </li>
                @if (Auth::user()->role_id != 2)
                <li class="{{ (Request::is('admin/status') ? 'active' : '') }}">
                    <a href="{!! route('admin.status') !!}"><i class="fa fa-book"></i>Status Layanan</a>
                </li>
                @endif
                <li class="{{ (Request::is('admin/item') ? 'active' : '') }}">
                    <a href="{!! route('admin.item') !!}"><i class="fa fa-book"></i>Jenis Pakaian</a>
                </li>
                <li class="{{ (Request::is('kasir/transaction') ? 'active' : '') }}">
                    <a href="{!! route('kasir.transaction') !!}"><i class="fa fa-book"></i>Transaksi</a>
                </li>
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  @if (Auth::user()->role_id != 2)
                    <li><a href="{!! route('admin.report.index') !!}"><i class="fa fa-book"></i>Gaji Karyawan</a></li>
                  @endif
                  <li><a href="{!! route('admin.report.daily') !!}"><i class="fa fa-book"></i>Transaksi Uang Masuk Harian</a></li>
                    <li><a href="{!! route('admin.report.status') !!}"><i class="fa fa-book"></i>Status Transaksi Harian</a></li>
                </ul>
              </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login: {{Auth::user()->name}}<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{!! URL::to('/auth/logout') !!}" class="navbar-link">Logout</a></li>
            </ul>
          </li>
          </ul>

            <p class="navbar-text navbar-right"></p>
        </div>
    </div>
</nav>
