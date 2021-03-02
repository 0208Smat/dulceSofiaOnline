function toggleEditElements(){
  var inputArray = document.getElementsByClassName("myinput");
  for(var i = 0; i < inputArray.length; i++){
    inputArray[i].removeAttribute("disabled");
  }
  document.getElementById("updateButton").classList.toggle("myHide");
  document.getElementById("editButton").classList.toggle("myHide");
}

function toggleTable(divElement){
  divElement.getElementsByTagName("table")[0].classList.toggle("myHide");
}

function fireSearchOrders(){
  var searchParam = document.getElementById("search_param").value;
  var fromDate = document.getElementById("from_date").value;
  var toDate = document.getElementById("to_date").value;
  //alert("searchParam"+searchParam+", fromDate: "+fromDate+", toDate: "+toDate);
  $("#searchResultTbody").load("includes/process.inc.php", {
    action: "search_orders",
    search_parameter: searchParam,
    from_date: fromDate,
    to_date: toDate
  }, function(){
    validateGeneralAmount();
  });
}

function validateGeneralAmount(){
  var amountArray = document.getElementsByClassName("net_total");
  var sum = 0;
  var quantity = amountArray.length;
  document.getElementById("quantityContainer").innerHTML = quantity;

  for(var i = 0; i < amountArray.length; i++){
    sum += Number(amountArray[i].value);
  }
  document.getElementById("generalAmountContainer").innerHTML = applyPygFormat(sum) + " Gs.";
  document.getElementById("netAverageContainer").innerHTML = applyPygFormat(Math.floor(sum/quantity)) + " Gs.";

  amountArray = document.getElementsByClassName("gross_total");
  sum = 0;
  for(var i = 0; i < amountArray.length; i++){
    sum += Number(amountArray[i].value);
  }
  document.getElementById("grossAmountContainer").innerHTML = applyPygFormat(sum) + " Gs.";
  document.getElementById("grossAverageContainer").innerHTML = applyPygFormat(Math.floor(sum/quantity)) + " Gs.";
}

function applyPygFormat(value){
  var formatter = new Intl.NumberFormat('de-DE');
  return formatter.format(String(value));
}

function confirmDelete(){
  var result = confirm("¿Seguro que desea eliminar este pedido?");
  return result;
}
