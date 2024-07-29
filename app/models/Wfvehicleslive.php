<?php


/**
 * Cargo class
 */
class Wfvehicleslive
{

    use Model;

    protected $table = 'wf_vehicles_live';

    protected $allowedColumns = [
        'id',
        'objectno',
        'name',
        'longitude',
        'latitude',
        'position_text',
        'odometer',
        'ignition',
        'standstill',
        'ignition_time',
        'position_time',
        'lng',
        'lat',
        'odometer_long',
        'fuel_lvl_ml',
        'fuel_lvl',
        'date',
        'u_id',
    ];

    public function getVehicle($id)
    {
        $query = "select * from $this->table WHERE objectno = $id ORDER BY date DESC LIMIT 1;";
        return $this->query($query);
    }

    public function getFulldataByDate($date) {
        $query = "SELECT 
            *,
            c.objectno AS CarObjectNo,
            u.id AS UserId,
            cd.date_from AS DateFrom,
            cd.date_to AS DateTo
        FROM 
            cars c
        LEFT JOIN 
            car_driver cd ON c.objectno = cd.car_id
        LEFT JOIN 
            users u ON u.id = cd.u_id
        WHERE 
            (cd.date_from IS NULL AND cd.date_to IS NULL) OR
            (cd.date_from <= '$date' AND (cd.date_to >= '$date' OR cd.date_to IS NULL))
        ORDER BY 
            c.objectno;";
        return $this->query($query);

    }
    public function getNewestData()
    {
        $query = "WITH LatestVehicleData AS (
                SELECT 
                    wvl.*
                FROM 
                    wf_vehicles_live wvl
                INNER JOIN (
                    SELECT 
                        objectno, 
                        MAX(date) AS max_date
                    FROM 
                        wf_vehicles_live
                    GROUP BY 
                        objectno
                ) latest ON wvl.objectno = latest.objectno AND wvl.date = latest.max_date
            )

            SELECT 
                lvd.id AS VehicleID,
                lvd.objectno AS VehicleObjectNo,
                lvd.name AS VehicleName,
                lvd.longitude,
                lvd.latitude,
                lvd.position_text,
                lvd.odometer,
                lvd.ignition,
                lvd.standstill,
                lvd.ignition_time,
                lvd.position_time,
                lvd.lng,
                lvd.lat,
                lvd.odometer_long,
                lvd.fuel_lvl_ml,
                lvd.fuel_lvl,
                lvd.date AS VehicleDate,
                u.id AS UserID,
                u.email AS UserEmail,
                u.first_name AS UserFirstName,
                u.last_name AS UserLastName,
                u.phone_business AS UserPhoneBusiness,
                u.phone_private AS UserPhonePrivate,
                c.id AS CarID,
                c.objectname AS CarObjectName,
                c.model AS CarModel,
                c.color AS CarColor,
                c.plate AS CarPlate,
                c.active AS CarActive,
                c.fuel_type AS CarFuelType,
                c.tank_cap AS CarTankCap
            FROM 
                LatestVehicleData lvd
            LEFT JOIN 
                users u ON lvd.u_id = u.id
            LEFT JOIN 
                cars c ON lvd.objectno = c.objectno;
            ";
        return $this->query($query);
    }
}