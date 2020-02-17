<?php
namespace slicing;

use \dtos\paymentdto;
use \slicing\database;

class payment extends database
{
    public function recent($customer_id="")
    {
        $payments = [];

        # @todo Limit to Customer ID
        #$payments_sql="SELECT * FROM payments LIMIT 500;";
        $payments_sql="
SELECT
    pay.*,
    prj.project_name
FROM payments pay
INNER JOIN projects prj ON prj.project_id = pay.project_id
INNER JOIN customers c ON c.customer_id=prj.customer_id
WHERE
    c.customer_id=:customer_id
ORDER BY
    pay.payment_on DESC
LIMIT 500
;";
        # @todo order by payment on desc, limit by sessioned customer
        $statement = $this->database->prepare($payments_sql);
        $statement->bindParam(":customer_id", $customer_id, SQLITE3_TEXT);
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $paymentdto = new paymentdto();
            $paymentdto->id = $row["payment_id"];
            $paymentdto->project = $row["project_id"];
            $paymentdto->reference = $row["payment_reference"];
            $paymentdto->amount = $row["payment_amount"];
            $paymentdto->date = $row["payment_on"];
            
            $paymentdto->name = $row["project_name"];
            
            $payments[] = $paymentdto;
        }
        
        return $payments;
    }
    
    public function recent_admin()
    {
        $payments = [];

        # @todo Limit to Customer ID
        #$payments_sql="SELECT * FROM payments LIMIT 500;";
        $payments_sql="
SELECT
    pay.*,
    prj.project_name
FROM payments pay
INNER JOIN projects prj ON prj.project_id = pay.project_id
INNER JOIN customers c ON c.customer_id=prj.customer_id
ORDER BY
    pay.payment_on DESC
LIMIT 500
;";
        # @todo order by payment on desc, limit by sessioned customer
        $statement = $this->database->prepare($payments_sql);
        $result = $statement->execute();
        while($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            # @Todo DTO Conversion
            $paymentdto = new paymentdto();
            $paymentdto->id = $row["payment_id"];
            $paymentdto->project = $row["project_id"];
            $paymentdto->reference = $row["payment_reference"];
            $paymentdto->amount = $row["payment_amount"];
            $paymentdto->date = $row["payment_on"];
            
            $paymentdto->name = $row["project_name"];
            
            $payments[] = $paymentdto;
        }
        
        return $payments;
    }
    
    public function maintenance()
    {
        //
    }
}