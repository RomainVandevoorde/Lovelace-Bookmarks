let forms = document.getElementsByTagName('form');
let xhr = getXMLHttpRequest();

function getXMLHttpRequest() {
  let xhr = null;

	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest();
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}

	return xhr;
}

for(let i = 0; i < forms.length; i++) {
  forms[i].addEventListener('submit', dispatchForm);
}

function dispatchForm(event) {
  event.preventDefault();
  let parameters = getArguments(event.target);
  let action = event.target.action;
  let method = event.target.method;
  request(method,action,parameters,reply);
}

function getArguments(target){
  let childs = getChilds(target);
  let parameters = "";
  for (let i = 0; i < childs.length; i++) {
    parameters += childs[i].name + "=" + ((childs[i].name == "url")?encodeURI(childs[i].value):childs[i].value);
    if(i < childs.length - 1){
      parameters += "&";
    }
  }
  return parameters;
}

function getChilds(target){
  let childs = [];
  let inputs = target.getElementsByTagName("input");
  let textAreas = target.getElementsByTagName("textarea");
  for (let i = 0; i < inputs.length; i++) {
    if(inputs[i].type != "submit"){
      childs.push(inputs[i]);
    }
  }
  for (let i = 0; i < textAreas.length; i++) {
    childs.push(textAreas[i]);
  }
  return childs;
}

function request(method,action,parameters,callback) {
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
		}
	};
	xhr.open(method, action, true);
  xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send(parameters);
}

function reply(response){
  // à définir :p
  console.log(response);
  let json = JSON.parse(response);
  if(json.success){
    console.log("Champagne!!!!!!!");
  }else{
    console.log("Fond de bière tiède :(");
  }
}
