<form method="post" action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
            <fieldset>
                <legend> Please Enter your name and table number: </legend>
                <label for="firstname">First name: </label>
                <input type="text" name="firstname" id="firstname"/> 

                <label for="tablenum">Table:</label>
                <select name="tablenum" id="tablenum">
                    <option value="T0000001">Table 1</option>
                    <option value="T0000002">Table 2</option>
                    <option value="T0000003">Table 3</option>
                    <option value="T0000004">Table 4</option>
                </select>

                <div class="submit">
                    <input type="submit" value="Order" />
                </div>
            </fieldset>
        </form>