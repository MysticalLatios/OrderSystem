<form method="post" action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
            <fieldset>
                <legend> Please submit your order: </legend>

                <label for="username"> HSU Oracle Username: </label>
                <input type="text" name="username" id="username" value=<?=strip_tags($_POST['username'])?>> 

                <label for="password"> HSU Oracle Password: </label>
                <input type="password" name="password" 
                id="password" />

                <br/>

                <label for="firstname"> Your first name: </label>
                <input type="text" name="firstname" id="firstname"/> 

                <label for="tablenum"> What Table are you sitting at? </label>
                <select name="tablenum" id="tablenum">
                    <option value="T0000001">Table 1</option>
                    <option value="T0000002">Table 2</option>
                    <option value="T0000003">Table 3</option>
                    <option value="T0000004">Table 4</option>
                </select>

                <label for="item"> What would you like to order? </label>
                <select name="item" id="item">
                    <option value="F0000001">Peperoni pizza</option>
                    <option value="F0000002">Pinaple pizza</option>
                    <option value="D0000001">Soda</option>
                </select>

                <div class="submit">
                    <input type="submit" value="Order" />
                </div>
            </fieldset>
        </form>