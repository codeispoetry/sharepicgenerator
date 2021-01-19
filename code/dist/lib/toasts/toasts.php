<div aria-live="polite" aria-atomic="true" class="toast-container">
  <div style="">

    <div class="toast toast-templates border-info" role="alert" aria-live="assertive" aria-atomic="true">
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

    <div class="toast upload-too-big border-info" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-info text-white">

        <strong class="mr-auto">Bild sehr groß</strong>
        <small class="small text-white"></small>
        <button type="button" class="ml-2 mb-1 close text-danger text-shadow-none" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        Dein Bild ist ziemlich groß. Der Sharepicgenerator braucht dafür recht lange.<br>
        Schneller geht's mit Bildern, die kleiner als 4000 Pixel sind.
      </div>
    </div>

    <div class="toast face-alert border-info" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-info text-white">

        <strong class="mr-auto">Gesicht</strong>
        <small class="small text-white"></small>
        <button type="button" class="ml-2 mb-1 close text-danger text-shadow-none" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        Das Bild zeigt ein Gesicht. Du brauchst die Erlaubnis der abgebildeten Person, um das Foto zu verwenden.
      </div>
    </div>

    <div class="toast other-tenant border-info" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-info text-white">

        <strong class="mr-auto">Regionales Layout</strong>
        <small class="small text-white"></small>
        <button type="button" class="ml-2 mb-1 close text-danger text-shadow-none" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        <a href="" id="other-tenant-url">Es gibt ein regionales Layout für <span id="other-tenant-name"></span>.<br>
        Klicke hier, um es zu nutzen.</a>
      </div>
    </div>

    <div class="toast toast-tipoftheday border-primary" data-id="tipmail" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-primary text-white">

        <strong class="mr-auto">Neu im Sharepicgenerator</strong>
        <small class="small text-white"></small>
        <button type="button" class="ml-2 mb-1 close text-danger text-shadow-none" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body tipoftheday cursor-pointer" data-target=".mail">
        Du kannst ein Sharepic direkt aus dem Sharepicgenerator an jemanden mailen.
      </div>
    </div>


    <?php
        echo $toasts;
    ?>    
  </div>
</div>