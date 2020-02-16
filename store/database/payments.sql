CREATE TABLE "payments" (
	"payment_id"	TEXT NOT NULL,
	"project_id"	TEXT NOT NULL,
	"payment_reference"	TEXT NOT NULL,
	"payment_on"	TEXT NOT NULL,
	"payment_amount"	NUMERIC NOT NULL DEFAULT 0.00,
	"payment_from"	TEXT NOT NULL,
	PRIMARY KEY("payment_id"),
    FOREIGN KEY(project_id) REFERENCES projects(project_id) ON DELETE CASCADE ON UPDATE CASCADE
);