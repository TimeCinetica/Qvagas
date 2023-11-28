<div class="modal micromodal-slide" id="modal-{{$id}}" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-{{$id}}-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-{{$id}}-title">
                    {{$title}}
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content">
                <p id="modal-{{$id}}-content">
                    {{$text}}
                </p>
            </main>
            <footer class="modal__footer">
                <button class="modal__btn modal__btn-primary" data-micromodal-close aria-label="Close this dialog window">OK, entendi</button>
            </footer>
        </div>
    </div>
</div>