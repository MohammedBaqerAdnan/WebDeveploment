<body>

    <?php
    // When the form is submitted, your code should validate each CPR entered by the user and  display them in HTML table as shown in the sample below. Note that the size of the CPR array  is unknown. 
    if (isset($_POST['cpr'])) {
        $cpr = $_POST['cpr'];
        echo '<table border="1">';
        echo '<tr><th>CPR</th><th>Valid</th></tr>';
        foreach ($cpr as $cprNumber) {
            if (preg_match('/^((8[1-9]|9\d)|([01]\d|2[0-2]))(0\d|1[0-2])\d{5}/', $cprNumber)) {
                echo '<tr><td>' . $cprNumber . '</td><td>Valid</td></tr>';
            } else {
                echo '<tr><td>' . $cprNumber . '</td><td>Invalid</td></tr>';
            }
        }
        echo '</table>';
    }
    ?>


    <form method="post">
        CPR: <input name="cpr[]" /><br />
        CPR: <input name="cpr[]" /><br />
        CPR: <input name="cpr[]" /><br />
        CPR: <input name="cpr[]" /><br />
        <input type="submit" value="Validate CPRs" />
    </form>
</body>