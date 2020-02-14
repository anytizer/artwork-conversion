CREATE TABLE "estimations" (
	"estimation_id"	TEXT NOT NULL,
	"project_id"	TEXT NOT NULL,
	"estimated_on"	TEXT NOT NULL,
	"estimated_budget"	NUMERIC NOT NULL DEFAULT 0.00,
	"estimated_notes"	TEXT NOT NULL,
	PRIMARY KEY("estimation_id")
);