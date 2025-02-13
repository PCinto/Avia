<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Plan Form</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
        }
        .full-width {
            width: 100%;
        }
        .half-width {
            width: 50%;
            display: inline-block;
        }
        .text-center {
            text-align: center;
        }
        .underline {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>FLIGHT PLAN</h1>

    <form action="#" method="post"> 
        <table>
            <tr>
                <td colspan="2">PRIORITY<br>
                    <input type="text" name="priority">
                </td>
                <td colspan="2">ADDRESSEE(S)<br>
                    <input type="text" name="addressee">
                </td>
            </tr>
            <tr>
                <td colspan="2">FILING TIME<br>
                    <input type="text" name="filing_time">
                </td>
                <td colspan="2">ORIGINATOR<br>
                    <input type="text" name="originator">
                </td>
            </tr>
            <tr>
                <td colspan="4">SPECIFIC IDENTIFICATION OF ADDRESSEE(S) AND/OR ORIGINATOR<br>
                    <input type="text" name="identification">
                </td>
            </tr>
            <tr>
                <td>3 MESSAGE TYPE<br>
                    <input type="text" name="message_type" value="FPL" readonly>
                </td>
                <td colspan="2">7 AIRCRAFT IDENTIFICATION<br>
                    <input type="text" name="aircraft_id">
                </td>
                <td>8 FLIGHT RULES<br>
                    <input type="text" name="flight_rules">
                </td>
            </tr>
            <tr>
                <td colspan="2">9 NUMBER<br>
                    <input type="text" name="number">
                </td>
                <td>TYPE OF AIRCRAFT<br>
                    <input type="text" name="aircraft_type">
                </td>
                <td>WAKE TURBULENCE CAT<br>
                    <input type="text" name="wake_turbulence">
                </td>
            </tr>
            <tr>
                <td colspan="2">10 EQUIPMENT<br>
                    <input type="text" name="equipment">
                </td>
                <td colspan="2">TYPE OF FLIGHT<br>
                    <input type="text" name="type_of_flight">
                </td>
            </tr>
            <tr>
                <td colspan="2">13 DEPARTURE AERODROME<br>
                    <input type="text" name="departure_aerodrome">
                </td>
                <td colspan="2">TIME<br>
                    <input type="text" name="departure_time">
                </td>
            </tr>
            <tr>
                <td colspan="2">15 CRUISING SPEED<br>
                    <input type="text" name="cruising_speed" value="N0">
                </td>
                <td colspan="2">LEVEL<br>
                    <input type="text" name="level">
                </td>
            </tr>
            <tr>
                <td colspan="4">ROUTE<br>
                    <input type="text" name="route">
                </td>
            </tr>
            <tr>
                <td colspan="2">16 DESTINATION AERODROME<br>
                    <input type="text" name="destination_aerodrome">
                </td>
                <td>TOTAL EET<br>
                    <input type="text" name="total_eet">
                </td>
                <td>ALTN AERODROME<br>
                    <input type="text" name="altn_aerodrome">
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2">2ND ALTN AERODROME<br>
                    <input type="text" name="second_altn_aerodrome">
                </td>
            </tr>
            <tr>
                <td colspan="4">18 OTHER INFORMATION<br>
                    <textarea name="other_information" rows="4" class="full-width"></textarea>
                </td>
            </tr>

            <tr>
                <td colspan="4" class="text-center underline">SUPPLEMENTARY INFORMATION (NOT TO BE TRANSMITTED IN FPL MESSAGES)</td>
            </tr>

            <tr>
                <td colspan="2">19 ENDURANCE<br>
                    <input type="text" name="endurance">
                </td>
                <td colspan="2">PERSONS ON BOARD<br>
                    <input type="text" name="persons_on_board">
                </td>
            </tr>
            <tr>
                <td colspan="4">SURVIVAL EQUIPMENT<br>
                    <input type="checkbox" name="survival_equipment[]" value="polar_desert"> POLAR DESERT
                    <input type="checkbox" name="survival_equipment[]" value="maritime"> MARITIME
                    <input type="checkbox" name="survival_equipment[]" value="jungle"> JUNGLE<br>
                    <input type="checkbox" name="survival_equipment[]" value="jackets"> JACKETS
                    <input type="checkbox" name="survival_equipment[]" value="light"> LIGHT
                    <input type="checkbox" name="survival_equipment[]" value="fluores"> FLUORES<br>
                    UHF <input type="checkbox" name="uhf">
                    VHF <input type="checkbox" name="vhf">
                    EMERGENCY RADIO <input type="checkbox" name="emergency_radio">
                    ELT <input type="checkbox" name="elt">
                </td>
            </tr>
            <tr>
                <td colspan="4">DINGHIES<br>
                    NUMBER <input type="text" name="dinghies_number" class="half-width">
                    CAPACITY <input type="text" name="dinghies_capacity" class="half-width"><br>
                    COVER <input type="text" name="dinghies_cover" class="half-width">
                    COLOUR <input type="text" name="dinghies_colour" class="half-width">
                </td>
            </tr>
            <tr>
                <td colspan="4">AIRCRAFT COLOUR AND MARKINGS<br>
                    <input type="text" name="aircraft_colour" class="full-width">
                </td>
            </tr>
            <tr>
                <td colspan="4">REMARK<br>
                    <textarea name="remark" rows="4" class="full-width"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">PILOT IN COMMAND<br>
                    <input type="text" name="pilot_in_command">
                </td>
                <td colspan="2">FILED BY<br>
                    <input type="text" name="filed_by">
                </td>
            </tr>
            <tr>
                <td colspan="4">SPACE RESERVED FOR ADDITIONAL REQUIREMENTS<br>
                    <textarea name="additional_requirements" rows="4" class="full-width"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="4">Please provide a telephone number our operators can contact you if needed<br>
                    <input type="text" name="contact_number" class="full-width">
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">
                    <input type="submit" value="Submit Flight Plan">
                </td>
            </tr>
        </table>
    </form>

</body>
</html>