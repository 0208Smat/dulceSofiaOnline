var selectedProductIds = "";
var selectedProductDescriptions = "";
var selectedProductPrices = "";
var selectedProductQuantities = "";
var selectedProductAmounts = "";
var productMap = new Map();

//Inicializamos funcionamiento de carga de pedido
$(document).ready(function(){
  $("#searchButton").click(function(){
    var searchParam = document.getElementById("searchParam").value;
    $("#searchResultTbody").load("load-products.php", {
      //estas variables se van al archivo .php como super variables POST
      action: "searchProductToAdd",
      search_parameter: searchParam
    });
  })
  $(".addButton").click(function(){
    //Cada elemento se pone a sí mismo como parámetro de la función
    addToOrder(this);
  })
});


function addToOrder(element){
    var selectedProductId = element.parentNode.parentNode.id;
    if(selectedProductIds.length == 0){
      selectedProductIds = selectedProductId;
    }else{
      var auxSelectedIdsArray = selectedProductIds.split(",");
      if(!auxSelectedIdsArray.includes(selectedProductId)){
          selectedProductIds += ","+selectedProductId;
      }
    }
    if(!productMap.has(selectedProductId)){
      $("#selectedProductsTbody").load("load-products.php", {
        action: "addProduct",
        selected_product_id: selectedProductId,
        selected_product_ids: selectedProductIds
        }, function() {
          productMap.forEach(function(value, key) {
          var tr = document.getElementById(key);
          var quantityInput = tr.getElementsByClassName("smallInput")[0];
          quantityInput.value = value.quantity;
          quantityInput.setAttribute("value", value.quantity);
          validateAmount(quantityInput);
          })
        });
      //al agregar siempre va a ser cantidad 0;
      productMap.set(selectedProductId, {quantity: 0});
      document.getElementById("obsInput").focus();
    }
}

function deleteRow(buttonElement){
  var tr = buttonElement.parentNode.parentNode;
  //validate global ids
  var productIdToDelete = tr.id;
  var selectedIdsArray = selectedProductIds.split(",");
  selectedIdsArray = removeFromArray(selectedIdsArray, productIdToDelete);
  selectedProductIds = "";
  for(var i = 0; i < selectedIdsArray.length; i++){
    if(i == 0){
      selectedProductIds = selectedIdsArray[0];
    }else{
      selectedProductIds += selectedProductIds +","+ selectedIdsArray[0];
    }
  }
  productMap.delete(productIdToDelete);
  validateAmount(buttonElement, true);
  tr.innerHTML="";
}

function removeFromArray(array, itemToDelete){
  for(var i = 0; i < array.length; i++){
    if(array[i] == itemToDelete){
      array.splice(i, 1);
    }
  }
  return array;
}

function displayFormatedNumber(inputElement) {
  var formatter = new Intl.NumberFormat('de-DE');
  var value = inputElement.value;
  var formatedContainer = inputElement.parentNode.getElementsByClassName("formatedNumber")[0];
  if(value == "" || value == null){
    value = 0;
  }
  value = Number(value);
  formatedContainer.innerHTML = formatter.format(value);
}

function alterQuantity(buttonElement){
  var operator = buttonElement.innerHTML;
  var inputElement = buttonElement.parentNode.getElementsByTagName("input")[0];
  var inputValue = inputElement.value;

  if(inputValue == "" || inputValue == null){
    inputValue = 0;
  }
  inputValue = Number(inputValue);
  if(operator == "+"){
    inputValue += 1;
  }else if(operator == "-" && inputValue > 0){
    inputValue -= 1;
  }
  inputElement.setAttribute("value", inputValue);
  inputElement.value = inputValue;
  validateAmount(buttonElement);
}

function validateQuantity(inputElement){
  if(Number(inputElement.value) < 0){
    inputElement.setAttribute("value", 0);
    inputElement.value = 0;
  }else{
    inputElement.setAttribute("value", inputElement.value);
  }
  validateAmount(inputElement);
}

function validateAmount(element, isDelete){
  var formatter = new Intl.NumberFormat('de-DE');
  var productRow = element.closest(".productRow");
  var inputElement = productRow.getElementsByClassName("smallInput")[0];
  var inputQuantity;
  if(inputQuantity == "" || inputQuantity == null){
    inputQuantity = 0;
  }
  if(isDelete){
    inputQuantity = 0;
  }else{
    inputQuantity = inputElement.value;
    //actualizamos en mapa global
    productMap.set(productRow.id, {quantity: inputQuantity});
  }
  var totalAmountContainer = productRow.getElementsByClassName("totalAmountContainer")[0];//monto neto visible
  var totalAmountInput = productRow.getElementsByClassName("totalAmountInput")[0];//monto neto para bd

  var totalGrossAmountContainer = productRow.getElementsByClassName("totalGrossAmountContainer")[0];//monto bruto visible
  var totalGrossAmountInput = productRow.getElementsByClassName("totalGrossAmountInput")[0];//monto bruto para bd

  var price = productRow.getElementsByClassName("priceContainer")[0].innerHTML;
  price = price.replaceAll(".","");
  price = Number(price);
  var cost = productRow.getElementsByClassName("costContainer")[0].innerHTML;
  cost = cost.replaceAll(".","");
  cost = Number(cost);

  //monto neto
  var newAmount = inputQuantity * (price - cost);
  totalAmountContainer.innerHTML = formatter.format(String(newAmount));
  totalAmountInput.setAttribute("value", newAmount);
  totalAmountInput.value = newAmount;
  //monto bruto
  newAmount = inputQuantity * price;
  totalGrossAmountContainer.innerHTML = formatter.format(String(newAmount));
  totalGrossAmountInput.setAttribute("value", newAmount);
  totalGrossAmountInput.value = newAmount;

  validateOrderAmount(productRow.parentNode, formatter);
}

function validateOrderAmount(tbodyElement, formatter){
  //var totalOrderContainerValue = Number(document.getElementById("totalOrderContainer").innerHTML);
  var productAmountArray = tbodyElement.getElementsByClassName("totalAmountContainer");
  var newValue = 0;
  var productAmount;
  for(var i = 0; i < productAmountArray.length; i++){
    productAmount = productAmountArray[i].innerHTML;
    productAmount = productAmount.replaceAll(".","");
    newValue += Number(productAmount);
  }
  document.getElementById("totalOrderContainer").innerHTML = formatter.format(String(newValue)) + " Gs.";
  document.getElementById("totalOrderInput").value = newValue;
  document.getElementById("totalOrderInput").setAttribute("value", newValue);

//  var totalOrderGrossContainerValue = Number(document.getElementById("totalGrossOrderContainer").innerHTML);
  productAmountArray = tbodyElement.getElementsByClassName("totalGrossAmountContainer");
  newValue = 0;
  for(var i = 0; i < productAmountArray.length; i++){
    productAmount = productAmountArray[i].innerHTML;
    productAmount = productAmount.replaceAll(".","");
    newValue += Number(productAmount);
  }
  document.getElementById("totalGrossOrderContainer").innerHTML = formatter.format(String(newValue)) + " Gs.";
  document.getElementById("totalGrossOrderInput").value = newValue;
  document.getElementById("totalGrossOrderInput").setAttribute("value", newValue);
}
