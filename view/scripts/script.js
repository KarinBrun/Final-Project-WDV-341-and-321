window.onload = function(){
    let usernameGet = getCookieValue("Logged In");
    if(usernameGet){
        document.getElementById('login').classList.replace('showLogin', 'hideLogin');
        document.getElementById('logout').classList.replace('hideLogout', 'showLogout');
        document.getElementById('admin').classList.replace('hideAdmin', 'showAdmin');
        document.querySelector("#welcomeMessage").innerHTML = "Welcome, " + usernameGet + "!";
    }

    $('#loginForm').submit(function(event){
        event.preventDefault();
        console.log('Starting form submit');
        let $form = $(this);
        let $inputs = $form.find("input, button");
        let serializedData = $form.serialize();
        request = $.ajax({
            url: "../controller/login.php",
            type: "post",
            data: serializedData
        });
        request.done(function (response, textStatus, jqXHR){
            // Log a message to the console
            console.log("Hooray, it worked!");
            console.log(response['username']);
            setCookie("Logged In", response['username'], 1);
            document.getElementById('login').classList.replace('showLogin', 'hideLogin');
            document.getElementById('logout').classList.replace('hideLogout', 'showLogout');
            window.location.href = "../view/adminHome.php";
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
            document.querySelector(".errorMessage").innerHTML = "Invalid username/password. Please try again"
        });
    })

    document.querySelector("#createIngredient").onclick = function() {
        createIngredientFunc();
    }

    document.querySelector("#createInstruction").onclick = function() {
        createInstructionFunc();
    }
}//end window.onload

function logout(){
    event.preventDefault();
    request = $.ajax({
        url: "../controller/logout.php",
        type: "get"
    });
    request.done(function(){
        deleteCookie("Logged In");
        window.location.href = "../view/index.php";
    });
    request.fail(function(){
        console.log("This should never happen");
    });
}

function hideIngredients(){
    let ingredientDiv = document.querySelector(".showIngredients");
    let ingredientArrow = document.querySelector("#ingredientArrow");
    if (ingredientDiv.style.display === "block"){
        ingredientDiv.style.display = "none";
        ingredientArrow.classList.remove('up');
        ingredientArrow.classList.add('down');
    }
    else {
        ingredientDiv.style.display = "block";
        ingredientArrow.classList.remove('down');
        ingredientArrow.classList.add('up');
    }
}

function hideInstructions(){
    let instructionDiv = document.querySelector(".showInstructions");
    let instructionArrow = document.querySelector("#instructionArrow");
    if (instructionDiv.style.display === "block"){
        instructionDiv.style.display = "none";
        instructionArrow.classList.remove('up');
        instructionArrow.classList.add('down');
    }
    else {
        instructionDiv.style.display = "block";
        instructionArrow.classList.remove('down');
        instructionArrow.classList.add('up');
    }
}

let rowCounterIngredient = 0;
let rowCounterInstruction = 0;

function createIngredientFunc(){
    rowCounterIngredient += 1;
    let tempObject = document.querySelector("#ingredientTemplate");
    let templateObject = tempObject.content.cloneNode(true);

    templateObject.querySelector("label[for=ingredientName]").htmlFor = "ingredientName" + rowCounterIngredient;
    templateObject.querySelector("label[for=ingredientQTY]").htmlFor = "ingredientQTY" + rowCounterIngredient;

    let nameObject = templateObject.querySelector("#ingredientName");
    let qtyObject = templateObject.querySelector("#ingredientQTY");
    qtyObject.id = "ingredientQTY" + rowCounterIngredient;
    qtyObject.name = "ingredients" + "[" + rowCounterIngredient + "]" + "[ingredientQty]";
    nameObject.id = "ingredientName" + rowCounterIngredient;
    nameObject.name = "ingredients" + "[" + rowCounterIngredient + "]" + "[ingredientName]";

    let divObject = document.querySelector(".ingredientBox");
    divObject.appendChild(templateObject);
}

function createInstructionFunc(){
    rowCounterInstruction += 1;
    let tempObject = document.querySelector("#instructionTemplate");
    let templateObject = tempObject.content.cloneNode(true);

    templateObject.querySelector("label[for=instructions]").htmlFor = "instructions" + rowCounterInstruction;

    let nameObject = templateObject.querySelector("#instructions");
    nameObject.id = "instructions" + rowCounterInstruction;

    let divObject = document.querySelector(".instructionBox");
    divObject.appendChild(templateObject);
}

function displayRecipeCard(parsedObject){
    let recipeCard = $("<div>",{class:"recipeCard"});

    let detailsRow = $("<div>",{class:"row"});

    let imageCol = $("<div>",{class:"col"});
    let recipeImage = $("<img>",{class:"recipeImage"});
    recipeImage.attr("src",parsedObject.recipeImage);
    imageCol.append(recipeImage);

    let colDetails = $("<div>",{class:"col"});

    let nameRow = $("<div>",{class:"row"});
    let recipeName = $("<h5>",{class:"text-align"}).text(parsedObject.recipeName);
    recipeName.attr("id","recipeCardName");
    nameRow.append(recipeName);

    let descRow = $("<div>",{class:"row"});
    let descCol = $("<div>",{class:"col"});
    let recipeDesc = $("<p></p>").text(parsedObject.recipeDescription);
    recipeDesc.attr("id","recipeCardDesc");
    descCol.append(recipeDesc);
    descRow.append(descCol);
    
    let difTimeRow = $("<div>",{class:"row"});
    let difCol = $("<div>",{class:"col-sm-4"});
    let difficulty = "";
    switch(parsedObject.recipeDifficulty){
        case 1:
            difficulty = "Easy";
            break;
        case 2:
            difficulty = "Medium";
            break;
        case 3:
            difficulty = "Hard";
            break;
    }
    let recipeDifficulty = $("<p></p>").text("Difficulty: " + difficulty);
    recipeDifficulty.attr("id", "recipeCardDifficulty");
    difCol.append(recipeDifficulty);
    timeCol = $("<div>",{class:"col-sm-4"});
    let recipeTime = $("<p></p>").text("Time Recipe Takes: " + parsedObject.recipeTime);
    recipeTime.attr("id","recipeCardTime");
    timeCol.append(recipeTime);
    difTimeRow.append(difCol,timeCol);

    let buttonRow = $("<div>",{class:"row"});
    let buttonCol = $("<div>",{class:"col"});
    let normalButton = $("<button></button>",{class: "btn btn-secondary recipeCardButtonNormal"}).text("Normal Recipe");
    normalButton.attr("id","recipeButtonNormal");
    normalButton.attr("onclick","rebuildIngredients('normal')");
    let halfButton = $("<button></button>",{class:"btn btn-secondary recipeCardButtonHalf"}).text("1/2 Recipe");
    halfButton.attr("id","recipeButtonHalf");
    halfButton.attr("onclick","rebuildIngredients('half')");
    let doubleButton = $("<button></button>",{class:"btn btn-secondary recipeCardButtonDouble"}).text("Double Recipe");
    doubleButton.attr("id","recipeButtonDouble");
    doubleButton.attr("onclick","rebuildIngredients('double')");
    buttonCol.append(normalButton,halfButton,doubleButton);
    buttonRow.append(buttonCol);

    let ingredTitleRow = $("<div>",{class:"row"});
    let ingredTitleCol = $("<div>",{class:"col-sm-2 addMargin"});
    let ingredientTitle = $("<h5></h5>").text("Ingredients");
    ingredTitleCol.append(ingredientTitle);

    let ingredHideCol = $("<div>",{class:"col-sm-2"});
    let ingredDiv = $("<div>",{onclick:"hideIngredients()"});
    let ingredArrow = $("<i></i>",{class:"arrow up"});
    ingredArrow.attr("id","ingredientArrow");
    ingredDiv.append(ingredArrow);
    ingredHideCol.append(ingredDiv);

    let insructTitleRow = $("<div>",{class:"row"});
    let instructTitleCol = $("<div>",{class:"col-sm-2 addMargin"});
    let instructTitle = $("<h5></h5>").text("Instructions");
    instructTitleCol.append(instructTitle);

    let instructHideCol = $("<div>",{class:"col-sm-2"});
    let instructDiv = $("<div>",{onclick:"hideInstructions()"});
    let instructArrow = $("<i></i>",{class:"arrow up"});
    instructArrow.attr("id","instructionArrow");
    instructDiv.append(instructArrow);
    instructHideCol.append(instructDiv);

    let showIngred = $("<div>",{class:"showIngredients"});
    for(n=0;n<parsedObject.ingredients.length;n++){
        let parsedIngredQTY = convertQTY(parsedObject.ingredients[n].ingredientQTY);
        let ingredQTY = $("<p></p>",{id:"recipeIngredientQTY"}).text(parsedIngredQTY);
        let ingredName = $("<p></p>",{id:"recipeIngredientName"}).text(parsedObject.ingredients[n].ingredientName);
        let ingredRow = $("<div>",{class:"row"});
        let ingredNameCol = $("<div>",{class:"col-sm-4"});
        let ingredQTYCol = $("<div>",{class:"col-sm-1 addMargin"});
        ingredQTYCol.append(ingredQTY);
        ingredNameCol.append(ingredName);
        ingredRow.append(ingredQTYCol, ingredNameCol);
        showIngred.append(ingredRow);
    }

    let showInstruct = $("<div>",{class:"showInstructions"});
    for(m=0;m<parsedObject.instructions.length;m++){
        let instructions = $("<p></p>",{id:"recipeInstruction"}).text(parsedObject.instructions[m]);
        let instructRow = $("<div>",{class:"row"});
        let instructCol = $("<div>",{class:"col addMargin"});
        instructCol.append(instructions);
        instructRow.append(instructCol);
        showInstruct.append(instructRow);
    }

    let br1 = $("<br>");
    let br2 = $("<br>");
    let br3 = $("<br>");
    let br4 = $("<br>");
    let br5 = $("<br>");
    let br6 = $("<br>");

    insructTitleRow.append(instructTitleCol,instructHideCol);
    ingredTitleRow.append(ingredTitleCol,ingredHideCol);
    colDetails.append(nameRow,descRow,br1,difTimeRow,br2,buttonRow,br3);
    detailsRow.append(imageCol,colDetails);

    recipeCard.append(br4,detailsRow,br5,ingredTitleRow,showIngred,br6,insructTitleRow,showInstruct);
    $(".recipeDiv").append(recipeCard);
}

function rebuildIngredients(portionSize){
    let currentRecipe = getCookieValue("currentRecipe");
    let parsedRecipe = JSON.parse(currentRecipe);
    let ingredients = [];
    for(i=0;i<parsedRecipe.ingredients.length;i++){
        let ingredient = new Ingredient(parsedRecipe.ingredients[i].ingredientName,parsedRecipe.ingredients[i].ingredientQTY);
        ingredients.push(ingredient);
    }
    let showIngred = $(".showIngredients");
    showIngred.empty();
    for(n=0;n<ingredients.length;n++){
        let parsedIngredQTY = "";
        switch(portionSize){
            case "half":
                parsedIngredQTY = convertQTY(ingredients[n].halfAmount());
                break;
            case "double":
                parsedIngredQTY = convertQTY(ingredients[n].doubleAmount());
                break;
            default:
                parsedIngredQTY = convertQTY(ingredients[n].ingredientQTY);
                break;
        }
        let ingredQTY = $("<p></p>",{id:"recipeIngredientQTY"}).text(parsedIngredQTY);
        let ingredName = $("<p></p>",{id:"recipeIngredientName"}).text(ingredients[n].ingredientName);
        let ingredRow = $("<div>",{class:"row"});
        let ingredNameCol = $("<div>",{class:"col-sm-4"});
        let ingredQTYCol = $("<div>",{class:"col-sm-1 addMargin"});
        ingredQTYCol.append(ingredQTY);
        ingredNameCol.append(ingredName);
        ingredRow.append(ingredQTYCol, ingredNameCol);
        showIngred.append(ingredRow);
    }
}

function convertQTY(qty){
    switch(qty){
        case 0.25:
            return "1/4";
        case 0.5:
            return "1/2";
        case 0.333:
            return "1/3";
        case 0.75:
            return "3/4";
        case 0.125:
            return "1/8";
        case 0.1665:
            return "1/6";
        case 0.375:
            return "3/8";
        case 0.666:
            return "2/3";
        default:
            return qty.toString();
    }
}



//validation

function submitContact(event){
    //runs validation and submits form contents
    let nameValid = nameValidation();
    let emailValid = emailValidation();
    let messageValid = messageValidation();
    if(nameValid && emailValid && messageValid){

    }
    else {
        event.preventDefault();
    }
}

function nameValidation(){
    //validates the name is filled
    let validForm = true;
    let displayName = document.querySelector("#name").value;
        if(displayName == ""){
            validForm = false;
            document.querySelector("#nameError").innerHTML = "Name cannot be blank.";
        }
        return validForm;
}

function emailValidation(){
    //validates the email is a valid format and is filled
    let validForm = true;
    let displayEmail = document.querySelector("#email").value;
        if(displayEmail == ""){
            validForm = false;
            document.querySelector("#emailError").innerHTML = "Email cannot be blank.";
        }
		else{
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(displayEmail)){
				document.querySelector("#email").innerHTML = displayEmail;
			}
			else{
				validForm = false;
            	document.querySelector("#emailError").innerHTML = "Email must be formatted correctly.";
			}
		}
        return validForm;
}

function messageValidation(){
    //validates the message is filled
    let validForm = true;
    let displayMessage = document.querySelector("#message").value;
        if(displayMessage == ""){
            validForm = false;
            document.querySelector("#messageError").innerHTML = "Message cannot be blank.";
        }
        return validForm;
}

function clearNameError(){
    //clears the name error message
    document.querySelector("#nameError").innerHTML = "";
}

function clearEmailError(){
    //clears the email error message
    document.querySelector("#emailError").innerHTML = "";
}

function clearMessageError(){
    //clears the message error message
    document.querySelector("#messageError").innerHTML = "";
}

function resetErrors(){
    //clears the error messages when clicking reset
    document.querySelector("#nameError").innerHTML = "";
    document.querySelector("#emailError").innerHTML = "";
    document.querySelector("#messageError").innerHTML = "";
}
