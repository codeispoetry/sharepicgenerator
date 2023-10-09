<?php
	$tenants = getActiveTenants();

if ( ! isset( $province ) || ! isset( $province->name ) ) {
	return;
}

if ( ! in_array( $province->name, array_values( $tenants ) ) ) {
	return;
}
	$link = array_search( $province->name, $tenants );
?>


<h3>Regionales Angebot</h3>
<div class="list-group-item list-group-item-action flex-column align-items-start">
	Für <?php echo $province->name; ?> gibt es ein     
	<a href="/<?php echo $link; ?>">Angebot im eigenen Design</a>.

</div>
