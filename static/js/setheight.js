window.onload=function(){
    var h1=document.getElementsByClassName('szheight2');
    var h2=document.getElementsByClassName('szheight1');
    for(var i=0;i<h1.length;i++)
    {
        h2[i].style.height=h1[i].offsetHeight+'px';
        h2[i].style.paddingTop=(h1[i].offsetHeight/2)-30+'px';
    }
}
