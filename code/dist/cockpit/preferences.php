<h3><i class="fas fa-cog"></i> 
    Einstellungen
</h3>
<div class="d-flex cockpitgridlines list-group-item list-group-item-action flex-column align-items-start">
    <label class="">
        <input id="gridlines" type="checkbox" class="me-1 form-check-input">
        Hilfslinien anzeigen
    </label>

    <label class="" title="ändere die Größe von Logo und Störer selbstständig">
        <input id="advancedmode" type="checkbox" class="me-1 form-check-input" >
        Hamák-Modus
    </label>
    <?php if('federal' == $tenant){; ?>
        <a href="#" class="mt-3 overlay-opener btn btn-sm btn-secondary" data-bs-target="preferences">Logos bearbeiten</a>
    <?php } ?>

    <label class="d-none">
        <input id="darkmode" type="checkbox" class="me-1 form-check-input">
        Dark-Mode
    </label>
</div>