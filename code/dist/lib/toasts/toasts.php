<div aria-live="polite" aria-atomic="true" class="toast-container">
  <div>

 <?php
 /*
    <div class="toast border-info" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-info text-white">

        <strong class="mr-auto">Vorlagen</strong>
        <small class="small text-white">just now</small>
        <button type="button" class="ml-2 mb-1 close text-danger text-shadow-none" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        See? Just like this.
      </div>
    </div>
*/
?>
    <div class="toast border-info" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-info text-white">

        <strong class="mr-auto">Vorlagen</strong>
        <small class="small text-white"></small>
        <button type="button" class="ml-2 mb-1 close text-danger text-shadow-none" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        <a href="gallery" target="_blank">
            <i class="fas fa-store"></i> Sieh Dir Vorlagen von anderen an.
        </a><br>
        Um eine eigene Vorlage zu veröffentlichen, klicke rechts auf <em>Vorlagen</em>.
      </div>
    </div>
    <?php
        echo $toasts;
    ?>    
  </div>
</div>