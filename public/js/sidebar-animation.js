const sidebarBtnOpen1 = document.getElementById("sidebar-toggle-1");
const sidebarBtnOpen2 = document.getElementById("sidebar-toggle-2");
const CajasBtns = document.getElementById("cajaBtnSidebar");
const BtnSibedarRespon = document.getElementById('btn-sibedar-responsive');
const sideBar = document.getElementById("sidebar");
const mainCaja = document.getElementById("cajaMain");

// BTN NO RESPONSIVE SIDEBAR
sidebarBtnOpen1.addEventListener("click",function(){
    sideBar.classList.toggle("sidebar-collapsed");
    mainCaja.classList.toggle("marginDefault");
    CajasBtns.classList.toggle("marginDefault");
});
// BTN YES RESPONSIVE SIDEBAR
sidebarBtnOpen2.addEventListener("click",function(){
    sideBar.classList.toggle("sidebar-responsive-collapsed");
});
// BTN CLOSE RESPONSIVE SIDEBAR
BtnSibedarRespon.addEventListener("click",function(){
    sideBar.classList.toggle("sidebar-responsive-collapsed");
});
// METODO PARA EVALUAR EL TAMAÑO DE LA PAGINA
function responsivePage(){
    if (window.innerWidth <= 768) {

        sideBar.removeAttribute('class');
        sideBar.setAttribute('class', 'js-sidebar-responsive sidebar-responsive-collapsed');

        mainCaja.classList.remove("marginDefault");
        CajasBtns.classList.remove("marginDefault");
        
        sidebarBtnOpen1.classList.add('d-none');

        sidebarBtnOpen2.classList.remove('d-none');

        BtnSibedarRespon.classList.remove('d-none');

    }else{
        sideBar.removeAttribute('class');
        sideBar.setAttribute('class', 'js-sidebar');

        mainCaja.classList.add("marginDefault");
        CajasBtns.classList.add("marginDefault");

        sidebarBtnOpen1.classList.remove('d-none');

        sidebarBtnOpen2.classList.add('d-none');

        BtnSibedarRespon.classList.add('d-none');
    }
}
// INVOCAR METODO CON LOS SIGUIENTES EVENTOS
window.addEventListener('load', responsivePage); 
window.addEventListener('resize', responsivePage); 