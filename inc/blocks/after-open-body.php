<!-- BEGIN header.txt -->
<?php hesk_require('header.txt'); ?>
<!-- END header.txt -->

<!-- Loader BEGIN -->
<style>
/* HTML: <div class="loader"></div> */
.loader-container {
    background: <?= $hesk_settings['loading_color'] ?? '#1483c5' ?>;
    width: 100%;
    height: 100vh;
    position: fixed;
    display: revert;
    z-index: 1500;
}

.loader-container-sub {
    color: white;
    text-align: center;
    position: relative;
    width: 14rem;
    margin-left: auto;
    margin-right: auto;
    margin-top: 50vh;
}

.loader {
    width: 50px;
    padding: 8px;
    aspect-ratio: 1;
    border-radius: 50%;
    background: #25b09b;
    --_m:
        conic-gradient(#0000 10%, #000),
        linear-gradient(#000 0 0) content-box;
    -webkit-mask: var(--_m);
    mask: var(--_m);
    -webkit-mask-composite: source-out;
    mask-composite: subtract;
    animation: l3 1s infinite linear;
    margin-left: auto;
    margin-right: auto;
}

@keyframes l3 {
    to {
        transform: rotate(1turn)
    }
}
</style>
<div class="loader-container">
    <div class="loader-container-sub">
        <div class="loader"></div>
    </div>
</div>
<script>
globalThis.LoadingScreen = {
    show(after = 500) {
        after = !isNaN(parseInt(after)) && after >= 0 ? parseInt(after) : 0;

        setTimeout(() => {
            document.querySelector('.loader-container').style.display = 'block';
        }, after);
    },
    hide(after = 500) {
        after = !isNaN(parseInt(after)) && after >= 0 ? parseInt(after) : 0;

        setTimeout(() => {
            document.querySelector('.loader-container').style.display = 'none';
        }, after);
    },
}
document.addEventListener('DOMContentLoaded', (event) => {
    globalThis.LoadingScreen.hide(500);
});
</script>
<!-- Loader END -->
