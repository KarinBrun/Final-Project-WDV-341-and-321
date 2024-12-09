class Ingredient {
    ingredientName = "";
    ingredientQTY = 0.0;

    constructor(inIngredientName, inIngredientQTY){
        this.ingredientName = inIngredientName;
        this.ingredientQTY = inIngredientQTY;
    }

    halfAmount(){
        return (this.ingredientQTY / 2);
    }

    doubleAmount(){
        return (this.ingredientQTY * 2);
    }

}