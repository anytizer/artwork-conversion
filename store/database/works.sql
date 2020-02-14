CREATE TABLE "works" (
	"work_id"	TEXT NOT NULL,
	"work_name"	TEXT NOT NULL UNIQUE,
	"work_desc"	TEXT NOT NULL,
	"work_active"	INTEGER NOT NULL,
	PRIMARY KEY("work_id")
);