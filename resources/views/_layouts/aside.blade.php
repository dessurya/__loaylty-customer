<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('vendors/adminlte-dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
    	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    		<div class="image">
    			<img src="{{ asset('vendors/adminlte-dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
    		</div>
    		<div class="info">
    			<a href="{{ route('self-data') }}" class="d-block">{{ Auth::guard('user')->user()->name }}</a>
    		</div>
    	</div>

    	<nav class="mt-2">
    		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    			<li class="nav-item">
    				<a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-tachometer-alt"></i>
    					<p>Dashboard</p>
    				</a>
    			</li>
    			<li class="nav-item">
    				<a href="{{ route('user.index') }}" class="nav-link {{ Route::is('user*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-user-tie"></i>
    					<p>User</p>
    				</a>
    			</li>
    			<li class="nav-item">
    				<a href="#" class="nav-link {{ Route::is('master*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-cogs"></i>
    					<p>Master<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
    					<li class="nav-item">
    						<a href="{{ route('master.website.index') }}" class="nav-link">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Website</p>
    						</a>
    					</li>
    					<li class="nav-item">
    						<a href="{{ route('master.bank.index') }}" class="nav-link">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Bank</p>
    						</a>
    					</li>
    					<li class="nav-item">
    						<a href="{{ route('master.tier.index') }}" class="nav-link">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Tier</p>
    						</a>
    					</li>
    				</ul>
    			</li>
    			<li class="nav-item">
    				<a href="{{ route('customer.index') }}" class="nav-link {{ Route::is('customer*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-users"></i>
    					<p>Customer</p>
    				</a>
    			</li>
    		</ul>
    	</nav>
    </div>
</aside>