
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
	
</style>
<link rel="stylesheet" type="text/css" href="assets/css/matarial.css">
<nav id="sidebar" class='mx-lt-5 bg-white' >
		
		<div class="sidebar-list">
			<div  id="sidebar-menu" class="sidebar-inner">
                <ul class="p-0">
					<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'> <i data-feather="airplay"></i></span> Dashboard</a>

				

					 <li class="has_sub">
                        <a href="javascript:void(0);" class="nav-item nav-categories waves-effect">
                            <i data-feather="home"></i>
                                <span> Properties</span> <span class="float-right">
                                   <i class="mdi mdi-chevron-right"></i>
                                    </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="index.php?page=properties">Buildings</a></li>
                                    <li><a href="index.php?page=apartments">Apartments</a></li>
                                    <li><a href="index.php?page=leases">Leases</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                        <a href="javascript:void(0);" class="nav-item nav-categories waves-effect">
                            <i data-feather="credit-card"></i>
                                <span> Accounts</span> <span class="float-right">
                                   <i class="mdi mdi-chevron-right"></i>
                                    </span></a>
                                <ul class="list-unstyled">
                                <li><a href="index.php?page=invoices">Invoices</a></li>    
                                <li><a href="index.php?page=expenses">Expenses</a></li>
                                <li><a href="index.php?page=payments">Payments</a></li>    
                                <li><a href="#">Bank Payments</a></li>
                                </ul>
                            </li>

					<li class="has_sub">
                        <a href="javascript:void(0);" class="nav-item nav-categories waves-effect">
                            <i data-feather="tool"></i>
                                <span> Maintainance</span> <span class="float-right">
                                   <i class="mdi mdi-chevron-right"></i>
                                    </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="index.php?page=houses">Repairs</a></li>
                                </ul>
                            </li>
					<a href="index.php?page=tenants" class="nav-item nav-tenants"><span class='icon-field'><i data-feather="shopping-bag"></i></span> Purchases</a>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="nav-item nav-categories waves-effect">
                            <i data-feather="message-square"></i>
                                <span> Messages</span> <span class="float-right">
                                   <i class="mdi mdi-chevron-right"></i>
                                    </span></a>
                                <ul class="list-unstyled">
                                <li><a href="index.php?page=add_building">Sent Box</a></li>    
                                </ul>
                            </li>
                    
                            <li class="has_sub">
                        <a href="javascript:void(0);" class="nav-item nav-categories waves-effect">
                            <i data-feather="users"></i>
                                <span> Users</span> <span class="float-right">
                                   <i class="mdi mdi-chevron-right"></i>
                                    </span></a>
                                <ul class="list-unstyled">
                                <li><a href="index.php?page=add_building">Staff</a></li>    
                                <li><a href="index.php?page=clients">Clients</a></li>
                                <li><a href="#">Landlords</a></li>    
                                <li><a href="#">Suppliers</a></li>
                                </ul>
                            </li>
					
					<li class="has_sub">
                        <a href="javascript:void(0);" class="nav-item nav-categories waves-effect">
                            <i data-feather="book-open"></i>
                                <span>  Reports</span> <span class="float-right">
                                   <i class="mdi mdi-chevron-right"></i>
                                    </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="index.php?page=payment_report">Monthly Payments Report</a></li>
                                    <li><a href="index.php?page=balance_report">Rental Balances Report</a></li>
                                </ul>
                            </li>
					
					
					<a href="#" class="nav-item" target="_blank"><span class='icon-field'> <i data-feather="film"></i></span> Pro Version</a>

<a href="#" class="nav-item" target="_blank"><span class='icon-field'> <i data-feather="gift"></i></span> More Project</a>


				</ul>
			</div>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
<script src="https://unpkg.com/feather-icons@4.29.1/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>

<script>
	$(document).ready(function() {
    // Hide all submenus by default
    $('.has_sub ul').hide();

    // Bind click event to menu items with submenus
    $('.has_sub > a').click(function(e) {
        e.preventDefault(); // Prevent default link behavior
        var $submenu = $(this).next('ul'); // Find the submenu

        // Close all other submenus
        $('.has_sub ul').not($submenu).slideUp();

        // Toggle the clicked submenu's visibility
        $submenu.slideToggle();

        // Toggle active class on the clicked menu item
        $(this).toggleClass('nav-active');
    });
});

</script>
