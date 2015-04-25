
blocnotes_data

Column	Type	Null	Default	Comments
id	int(11)	No 	 	 
filename_id	int(11)	Yes 	NULL 	 
hachset_filename	varchar(1024)	Yes 	NULL 	 
hash_key	varchar(2048)	Yes 	NULL 	 
filename	varchar(1024)	Yes 	NULL 	 
folder_name	varchar(1024)	Yes 	NULL 	 
content_file	longblob	Yes 	NULL 	 
isHach	tinyint(1)	Yes 	1 	 
isClear	tinyint(1)	Yes 	1 	 
isCrypted	tinyint(1)	Yes 	0 	 IndexesDocumentation
Keyname	Type	Unique	Packed	Column	Cardinality	Collation	Null	Comment
PRIMARY	BTREE	Yes	No	id	0	A	No	


Space usage:
Data	0	B
Index	1,024	B
Total	1,024	B
 	Row Statistics:
Format	dynamic
Rows	0
Next autoindex	1
Creation	Apr 21, 2015 at 04:27 AM
Last update	Apr 21, 2015 at 04:27 AM
