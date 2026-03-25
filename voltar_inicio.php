<!-- Botão Voltar ao Início -->
<button class="btn-voltar-inicio" id="btnVoltarInicio" title="Voltar ao início">⬆️</button>

<script>
// Mostrar/Esconder botão de voltar ao início
window.addEventListener('scroll', function() {
    const btnVoltar = document.getElementById('btnVoltarInicio');
    if (window.pageYOffset > 300) {
        btnVoltar.classList.add('visible');
    } else {
        btnVoltar.classList.remove('visible');
    }
});

// Clique no botão para voltar ao topo
document.getElementById('btnVoltarInicio').addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>
