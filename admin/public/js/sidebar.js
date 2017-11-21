/**
 * Created by JonathanTorres on 25-Oct-17.
 */


function openMenu() {
    document.getElementById("page-wrapper").style.margin = "0 0 100px 250px";
    document.getElementById("side-menu").style.display = "block";
    document.getElementById("dropdownArrow").style.display = "inline-flex";
    document.getElementById("side-menu").style.width = "250px";
    var sidebars = document.getElementsByClassName("sidebar");
    var texts = document.getElementsByClassName("menuText");
    paragraphVisible(texts);
    openMarginSidebar(sidebars);
}

function closeMenu() {
    document.getElementById("page-wrapper").style.margin = "0 0 100px 50px";
    document.getElementById("side-menu").style.width = "50px";
    document.getElementById("dropdownArrow").style.display = "none";
    document.getElementById("dropdownList").className = "dropdown";
    var sidebars = document.getElementsByClassName("sidebar");
    var texts = document.getElementsByClassName("menuText");
    paragraphInvisible(texts);
    closeMarginSidebar(sidebars);
    closeDropdownDiv();
}

function paragraphVisible(texts)
{
    for(var i=0, len=texts.length; i<len; i++)
    {
        texts[i].style.display = 'initial';
    }
}

function paragraphInvisible(texts)
{
    for(var i=0, len=texts.length; i<len; i++)
    {
        texts[i].style.display = 'none';
    }
}

function openMarginSidebar(sidebars)
{
    for(var i=0, len=sidebars.length; i<len; i++)
    {
        sidebars[i].style.width = '250px';
    }
}

function closeMarginSidebar(sidebars)
{
    for(var i=0, len=sidebars.length; i<len; i++)
    {
        sidebars[i].style.width = '50px';
    }
}

function openDropdownDiv() {
    document.getElementById("dropdownList").style.maxHeight = "360px";
}

function closeDropdownDiv() {
    setTimeout(function () {

    }, 1000 );
    document.getElementById("dropdownList").style.maxHeight = "0px";

}