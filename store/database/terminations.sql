CREATE TABLE "terminations" (
	"termination_id"	TEXT NOT NULL,
	"project_id"	TEXT NOT NULL,
	"termination_reason"	INTEGER NOT NULL DEFAULT 0,
	"termination_date"	TEXT NOT NULL DEFAULT '0000-00-00 00:00:00',
	"termination_by"	TEXT NOT NULL DEFAULT "",
	PRIMARY KEY("termination_id"),
    FOREIGN KEY(project_id) REFERENCES projects(project_id)
);