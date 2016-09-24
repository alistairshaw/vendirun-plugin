<div class="add-to-cart">
    <input type="number" step="1" min="1" name="quantity" id="quantity" value="1">
    <span class="price js-product-price">{{ CurrencyHelper::formatWithCurrency($selectedVariation->getPrice()) }}</span>
    <button type="submit" class="btn btn-primary js-standard-add-to-cart">Add to Cart</button>
</div>