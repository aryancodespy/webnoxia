window.addEventListener('load', onLoad);

function onLoad () {
    const copyrightEl = document.getElementById('copyright');

    if (copyrightEl) {
    const currentYear = new Date().getFullYear();
    const copyrightText = `Copyright &copy; ${currentYear} <a href="#" class="copyright-link">Webnoxia</a>. All Right Reserved`;

    copyrightEl.innerHTML = copyrightText;
    }
}