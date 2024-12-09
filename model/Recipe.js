class Recipe{
    recipeName = "";
    recipeDescription = "";
    recipeImage = "";
    recipeDifficulty = 0;
    recipeTime = "";
    numOfPeople = 0;
    ingredients = [];
    instructions = [];

    constructor(inRecipeName, inRecipeDescription, inRecipeImage, inRecipeDifficulty, inRecipeTime, inNumOfPeople, inIngredients, inInstructions){
        this.recipeName = inRecipeName;
        this.recipeDescription = inRecipeDescription;
        this.recipeImage = inRecipeImage;
        this.recipeDifficulty = inRecipeDifficulty;
        this.recipeTime = inRecipeTime;
        this.numOfPeople = inNumOfPeople;
        this.ingredients = inIngredients;
        this.instructions = inInstructions;
    }

    
}