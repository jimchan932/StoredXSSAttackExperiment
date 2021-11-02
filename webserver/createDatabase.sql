
use auth;

create table authorized_users(name varchar(10),
                              password varchar(8),
                              primary key(name));


create table comments(nickname varchar(20),
		      comments varchar(200),
		      primary key(nickname)
		      );

insert into authorized_users (name, password)
       values ('jim123', '12345678');

insert into authorized_users (name, password)
       values ('hacker', '78539816');

grant select on auth.*
      to 'localhost'
      identified by 'root';



flush privileges;
