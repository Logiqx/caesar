CREATE USER 'lac_caesar' IDENTIFIED WITH mysql_native_password BY 'r34dwr1t3';
GRANT ALL ON lac_caesar.* TO lac_caesar;

CREATE USER 'lac_php' IDENTIFIED WITH mysql_native_password BY 'r34d0nly';
GRANT SELECT ON lac_caesar.* TO lac_php;
