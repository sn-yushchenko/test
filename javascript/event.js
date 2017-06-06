function getWidthField(classField)//определяем ширину поля ввода для всех обЪектов
{
    var el=document.getElementsByClassName(classField);
   for(var i=0;i<el.length;i++){
       document.getElementsByClassName(classField)[i].style.width=document.getElementsByClassName(classField)[i].parentNode.clientWidth-70+"px";
   } 
}
function main()//функция динамического изменения размеров для View "main"
{
    getWidthField("bodycomment");
    getWidthField("entryField");
}
function addEvents() //функция обработчик событий страницы
{
    document.addEventListener('click', function (event) {
        event = event || window.event;
        if (event.target.className == "entryField") {
           var id = event.target.getAttribute("id"); document.getElementById(id).setAttribute("rows", 3);
            } 
        
        else if (event.target.getAttribute("id") == "registration"){
                window.open("/test/registration", "Регистрация", "width=450,height=600,top=100,left=400");
        }
        else if (event.target.className== "respond"){
                var id=event.target.getAttribute("id");
                var element=document.getElementById("r"+id);
            if(element.style.display=="block"){
                element.style.display="none";
            }
            else {
                 element.style.display="block";
            }
            getWidthField("entryField");
        }

    })
}
window.onload = function (){
    main();
    addEvents();
    if(document.cookie!=undefined)
        {
            document.getElementById("newBut").style.display="block";
        }
}

