CREATE TABLE "artworks" (
	"artwork_id"	TEXT NOT NULL,
	"project_id"	TEXT NOT NULL,
	"artwork_name"	TEXT NOT NULL,
	"artwork_type"	TEXT NOT NULL,
	"artwork_error"	INTEGER NOT NULL,
	"artwork_size"	INTEGER NOT NULL,
	"artwork_path"	TEXT NOT NULL,
	"artwork_active"	INTEGER NOT NULL DEFAULT 0,
	"artwork_date"	TEXT NOT NULL,
	PRIMARY KEY("artwork_id")
);