<?php
$list = $pager->getComList('kart_requests', '*');
?>

<table width="100%" border="1">
    <tr>
        <td colspan="2" align="center" bgcolor="#003399"><strong class="white"> خوش آمدید - شما مدیر هستید</strong></td>
    </tr>
    <tr>
        <td width="85%" rowspan="14">
            <table width="100%" border="0" align="center">
                <tr>
                    <td width="10%" align="center" bgcolor="#99FFCC">کد پستی</td>
                    <td width="20%" align="center" bgcolor="#99FFCC">آدرس</td>
                    <td width="10%" align="center" bgcolor="#99FFCC">موبایل</td>
                    <td width="10%" align="center" bgcolor="#99FFCC">تلفن</td>
                    <td width="10%" align="center" bgcolor="#99FFCC">کد ملی</td>
                    <td width="10%" align="center" bgcolor="#99FFCC">شماره شناسنامه</td>
                    <td width="20%" align="center" bgcolor="#99FFCC">نام و نام خانوادگی</td>
                    <td width="10%" align="center" bgcolor="#99FFCC">کد کاربر</td>
                </tr>
                <?php
                foreach ($list as $row) {
                    echo "<tr bgcolor='#66FF00'>";
                    echo "<td align='center'>" . $row['zipcode'] . "</td>";
                    echo "<td align='center'>" . $row['address'] . "</td>";
                    echo "<td align='center'>" . $row['mobile'] . "</td>";
                    echo "<td align='center'>" . $row['phone'] . "</td>";
                    echo "<td align='center'>" . $row['codemeli'] . "</td>";
                    echo "<td align='center'>" . $row['shenasname'] . "</td>";
                    echo "<td align='center'>" . $row['fullname'] . "</td>";
                    echo "<td align='center'>" . $row['id'] . "</td>";
                    echo "</tr>";
                }
                ?>

            </table>
        </td>
    </tr>
</table>
