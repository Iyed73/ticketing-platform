<?php include "prefix.php"?>

<div class = "container-fluid py-5" style="margin-top: 20vh">
            
            <h2> All Events </h2>
            <a class = "btn btn-primary text-white" href = "<?="{$prefix}/event_addition"?>" role = "button"> Add Event </a>
            <br>
            <table class = "table">
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> Name </th>
                        <th> Venue </th>
                        <th> Date </th>
                        <th> Short Description </th>
                        <th> Long Description </th>
                        <th> Organizer </th>
                        <th> Total Tickets </th>
                        <th> Available Tickets </th>
                    </tr>
                </thead>
                    <tbody>
                        <?php
                            $servername  = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "Tickety";

                            //Create Connection
                            $connection = new mysqli($servername, $username, $password, $database);

                            //Check Connection
                            if($connection -> connect_error){
                                die("Connection failed: " . $connection -> connect_error);
                            }

                            //read all row from database table
                            $sql = "SELECT * FROM events";
                            $result = $connection -> query($sql);

                            if(!$result){
                                die("Invalid query: " . $connection -> error);
                            }

                            // read data of each row
                            while($row = $result -> fetch_assoc()){
                                echo "
                                <tr>
                                    <td> $row[id] </td>
                                    <td> $row[name] </td>
                                    <td> $row[venue] </td>
                                    <td> $row[eventDate] </td>
                                    <td> $row[shortDescription] </td>
                                    <td> $row[longDescription] </td>
                                    <td> $row[organizer] </td>
                                    <td> $row[totalTickets] </td>
                                    <td> $row[availableTickets] </td>
                                    <td>
                                        <a class = 'btn btn-primary btn-sm text-white' href = '#?id = $row[id]'>Edit</a>
                                        <a class  = 'btn btn-danger btn-sm text-white' href = '#?id = $row[id]'>Delete</a>
                                    </td>
                                </tr>
                                ";
                            }
                        ?>
                        
                    </tbody>
            </table>
                

        </div>