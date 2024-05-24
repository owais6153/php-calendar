

<?php
function events_calendar() {

    if (isset($_GET['month']) && isset($_GET['year'])) {
        $month = intval($_GET['month']);
        $year = intval($_GET['year']);
    } else {
        $month = date('m');
        $year = date('Y');
    }

    if ($month < 1) {
        $month = 12;
        $year--;
    } elseif ($month > 12) {
        $month = 1;
        $year++;
    }

    $prevMonth = $month - 1;
    $nextMonth = $month + 1;
    $prevYear = $year;
    $nextYear = $year;

    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear--;
    }
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
    }
    $calendar = '<div class="nav-buttons">
        <a href="?month=' . $prevMonth . '&year=' . $prevYear . '">Previous Month</a>
        <a href="?month=' . $nextMonth . '&year=' . $nextYear . '">Next Month</a>
    </div>';

    $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t', $firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
    $monthName = $dateComponents['month'];
    $dayOfWeek = $dateComponents['wday'];
    $today = date('Y-m-d');

    $calendar .= "<h2>$monthName $year</h2>";
    $calendar .= "<table>";
    $calendar .= "<tr>";

    foreach ($daysOfWeek as $day) {
        $calendar .= "<th>$day</th>";
    }

    $calendar .= "</tr><tr>";

    if ($dayOfWeek > 0) {
        for ($k = 0; $k < $dayOfWeek; $k++) {
            $calendar .= "<td></td>";
        }
    }

    $currentDay = 1;

    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $currentDay);
        if ($currentDate == $today) {
            $calendar .= "<td class='today'>$currentDay</td>";
        } else {
            $calendar .= "<td>$currentDay</td>";
        }

        $currentDay++;
        $dayOfWeek++;
    }

    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek;
        for ($i = 0; $i < $remainingDays; $i++) {
            $calendar .= "<td></td>";
        }
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;
}

?>


<?php 
echo events_calendar();
?>
