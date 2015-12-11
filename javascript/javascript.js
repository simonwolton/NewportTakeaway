function validate()
{
	var valid = true;
	var Name = document.forms["contactForm"]["name"].value;
	var mail = document.forms["contactForm"]["mail"].value;
	var message = document.getElementById("msg").value;
	if(Name == null || Name == "" || Name == " ")
	{
		  alert("Please enter your name");
		  return false;

	}
	if(/^[a-zA-Z ]+$/.test(Name) == false)
	{
		alert("Please enter your name correctly!");
		return false;
	}
	if(/.+\@.+\..+/.test(mail) == false)
	{
		alert("Please enter a valid email address");
		return false;
	}
	if(message == null || message == "" || message == " ")
	{
		alert("Please state your enquiry");
		return false;
	}
	return valid;
}
function defaultify()
{
	var backgroundColoursArray = new Array();
	backgroundColoursArray[0] = backgroundColoursArray[2] = "rgb(89,103,114)";
	backgroundColoursArray[1] = backgroundColoursArray[3] = backgroundColoursArray[4] = "rgb(235,235,235)";

	document.body.style.background = backgroundColoursArray[0];
	if (document.getElementById("content"))
		document.getElementById("content").style.backgroundColor = backgroundColoursArray[1];
	document.getElementById("search").style.backgroundColor = backgroundColoursArray[0];
	document.getElementById("footerleft").style.backgroundColor = backgroundColoursArray[1];
	document.getElementById("footermiddle").style.backgroundColor = backgroundColoursArray[1];
	document.getElementById("footerright").style.backgroundColor = backgroundColoursArray[1];
	if (document.getElementById("products"))
		document.getElementById("products").style.backgroundColor = backgroundColoursArray[1];

	document.cookie = 'backgroundColoursCookie=' + backgroundColoursArray + '; expires=Thu, 2 Aug 2014 20:47:11 UTC; path=/';

}
function colourChange(colour,id)
{	
	result = colour.match(/.{1,2}/g);
	/*redValue = result[0].toString(16); /*converts to hex */
	var rgbArray = {R: parseInt(result[0], 16), G:parseInt(result[1], 16), B:parseInt(result[2], 16)}; /*hex to dec*/
	var div1 = {R: parseInt(result[0], 16), G:parseInt(result[1], 16), B:parseInt(result[2], 16)};;
	var div2 = {R: parseInt(result[0], 16), G:parseInt(result[1], 16), B:parseInt(result[2], 16)};;
	var div3 = {R: parseInt(result[0], 16), G:parseInt(result[1], 16), B:parseInt(result[2], 16)};;
	var div4 = {R: parseInt(result[0], 16), G:parseInt(result[1], 16), B:parseInt(result[2], 16)};;
	
	if (rgbArray.R == 0)
	{
		div1.R = rgbArray.R + 10;
		div2.R = rgbArray.R + 15;
		div3.R = rgbArray.R + 20;
		div4.R = rgbArray.R + 25;
		
	}
	else if (rgbArray.R > 1)
	{
		div1.R = Math.ceil(rgbArray.R - (rgbArray.R * 0.2));
		div2.R = Math.ceil(rgbArray.R - (rgbArray.R * 0.3));
		div3.R = Math.ceil(rgbArray.R + (rgbArray.R * 0.1));
		div4.R = Math.ceil(rgbArray.R - (rgbArray.R * 0.4));
		
	}
	else if (rgbArray.R <= 255)
	{
		div1.R = Math.floor(rgbArray.R + (rgbArray.R * 0.2));
		div2.R = Math.floor(rgbArray.R + (rgbArray.R * 0.3));
		div3.R = Math.floor(rgbArray.R - (rgbArray.R * 0.1));
		div4.R = Math.floor(rgbArray.R + (rgbArray.R * 0.4));
		
	}

	if (rgbArray.G == 0)
	{
		div1.G = rgbArray.G + 10;
		div2.G = rgbArray.G + 15;
		div3.G = rgbArray.G + 20;
		div4.G = rgbArray.G + 25;
		
	}
	else if (rgbArray.G > 1)
	{
		div1.G = Math.ceil(rgbArray.G - (rgbArray.G * 0.2));
		div2.G = Math.ceil(rgbArray.G - (rgbArray.G * 0.3));
		div3.G = Math.ceil(rgbArray.G + (rgbArray.G * 0.1));
		div4.G = Math.ceil(rgbArray.G - (rgbArray.G * 0.4));
		
	}
	else if (rgbArray.G <= 255)
	{
		div1.G = Math.floor(rgbArray.G + (rgbArray.G * 0.2));
		div2.G = Math.floor(rgbArray.G + (rgbArray.G * 0.3));
		div3.G = Math.floor(rgbArray.G - (rgbArray.G * 0.1));
		div4.G = Math.floor(rgbArray.G + (rgbArray.G * 0.4));
		
	}

	if (rgbArray.B == 0)
	{
		div1.B = rgbArray.B + 10;
		div2.B = rgbArray.B + 15;
		div3.B = rgbArray.B + 20;
		div4.B = rgbArray.B + 25;
		
	}
	else if (rgbArray.B > 1)
	{
		div1.B = Math.ceil(rgbArray.B - (rgbArray.B * 0.2));
		div2.B = Math.ceil(rgbArray.B - (rgbArray.B * 0.3));
		div3.B = Math.ceil(rgbArray.B + (rgbArray.B * 0.1));
		div4.B = Math.ceil(rgbArray.B - (rgbArray.B * 0.4));
		
	}
	else if (rgbArray.B <= 255)
	{
		div1.B = Math.floor(rgbArray.B + (rgbArray.B * 0.2));
		div2.B = Math.floor(rgbArray.B + (rgbArray.B * 0.3));
		div3.B = Math.floor(rgbArray.B - (rgbArray.B * 0.1));
		div4.B = Math.floor(rgbArray.B + (rgbArray.B * 0.4));
	}
	
	var backgroundColoursArray = new Array();
	var colourTmp = colour.match(/.{1,2}/g);
	var backgroundArray = {R: parseInt(colourTmp[0], 16), G:parseInt(colourTmp[1], 16), B:parseInt(colourTmp[2], 16)};
	backgroundColoursArray[0] = "rgb(" + backgroundArray.R + "," + backgroundArray.G + "," + backgroundArray.B + ")";
	backgroundColoursArray[1] = "rgb(" + div1.R + "," + div1.G + "," + div1.B + ")";
	backgroundColoursArray[2] = "rgb(" + div2.R + "," + div2.G + "," + div2.B + ")";
	backgroundColoursArray[3] = "rgb(" + div3.R + "," + div3.G + "," + div3.B + ")";
	backgroundColoursArray[4] = "rgb(" + div4.R + "," + div4.G + "," + div4.B + ")";
	
	document.body.style.background = backgroundColoursArray[0];
	if (document.getElementById("content"))
		document.getElementById("content").style.backgroundColor = backgroundColoursArray[1];
	document.getElementById("search").style.backgroundColor = backgroundColoursArray[2];
	
	document.getElementById("footerleft").style.backgroundColor = backgroundColoursArray[3];
	document.getElementById("footermiddle").style.backgroundColor = backgroundColoursArray[3];
	document.getElementById("footerright").style.backgroundColor = backgroundColoursArray[3];	
	if (document.getElementById("products"))
		document.getElementById("products").style.backgroundColor = backgroundColoursArray[4];

	document.cookie = 'backgroundColoursCookie=' + backgroundColoursArray + '; expires=Thu, 2 Aug 2014 20:47:11 UTC; path=/';
}

