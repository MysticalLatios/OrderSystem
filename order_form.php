<form method="post" action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
            <fieldset>
                <legend> Please submit your order: </legend>
                <label for="item"> What would you like to order? </label>
                <select name="item" id="item">
                    <option value="F0000001">Peperoni pizza</option>
                    <option value="F0000002">Pinaple pizza</option>
                    <option value="F0000003">Grilled Cheese</option>
                    <option value="F0000004">Fried Chiken Slabs</option>
                    <option value="D0000001">Soda</option>
                    <option value="D0000002">Ice Tea</option>
                </select>

                <div class="submit">
                    <input type="submit" value="Order" />
                </div>
            </fieldset>
        </form>