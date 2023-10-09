<!-- Version:  <?php system( "pwd -P | cut -d '/' -f 6" ); ?> -->
<div class="d-flex">

	<ul class="navbar-nav mr-auto mt-2 mt-lg-0">

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Über
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a href="/imprint.php" class="dropdown-item">
					<i class="fa fa-landmark"></i> Impressum
				</a>
				<a href="/imprint.php" class="dropdown-item">
					<i class="fa fa-key"></i> Datenschutz
				</a>
				<?php if ( ! isFreeTenant() ) { ?>
				<a class="dropdown-item" href="https://wolke.netzbegruenung.de/apps/files/?dir=/1_Bundesverband/Design%20%26%20Grafik/%C3%9Cbergangs-Styleguide&fileid=53077561" target="_blank">
					<i class="fas fa-magic"></i> Styleguide
				</a>
				<a class="dropdown-item" href="https://chatbegruenung.de/channel/sharepicgenerator" target="_blank">
					<i class="fab fa-rocketchat"></i> Chatkanal
				</a>
				<?php } ?>
			</div>
		</li>

		<?php if ( ! isFreeTenant() ) { ?>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Regionale Angebote
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a href="/de" class="dropdown-item">Bundeslayout</a>
				<a href="/btw21" class="dropdown-item">Altes Bundeslayout</a>


				<div class="dropdown-divider"></div>
				<?php
				foreach ( getActiveTenants() as $key => $value ) {
					printf(
						'<a href="/%1$s" class="dropdown-item">%2$s</a>',
						$key,
						$value
					);
				}
				?>
			</div>
		</li>
		<?php } ?>

	</ul>
</div>


<h3><?php echo @explode( ',', configValue( 'Main', 'linkedTenants' )[ $tenant ] )[0]; ?></h3>

<div class="navbar-text d-flex">
	<em title="Zuletzt eingeloggt <?php echo getLastLogin(); ?>">
		<?php echo getUser(); ?>
		<?php
		if ( isEditor() ) {
			echo '(Editor)';

			printf( '<a href="/show.php?tenant=%s" class="ms-2"><i class="fas fa-images" title="Neueste Sharepics"></i></a>', $tenant );
		}
		?>
	</em>
	<a href="?logout=true" class="ms-2"><i class="fas fa-sign-out-alt" title="Ausloggen"></i></a>
</div>
