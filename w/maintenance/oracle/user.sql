-- defines must comply with ^define\s*([^\s=]*)\s*=\s?'\{\$([^\}]*)\}';
define wiki_wiki_user='{$wgDBwiki_user}';
define wiki_pass='{$wgDBpassword}';
define def_ts='{$_OracleDefTS}';
define temp_ts='{$_OracleTempTS}';

create wiki_user &wiki_wiki_user. identified by &wiki_pass. default tablespace &def_ts. temporary tablespace &temp_ts. quota unlimited on &def_ts.;
grant connect, resource to &wiki_wiki_user.;
grant alter session to &wiki_wiki_user.;
grant ctxapp to &wiki_wiki_user.;
grant execute on ctx_ddl to &wiki_wiki_user.;
grant create view to &wiki_wiki_user.;
grant create synonym to &wiki_wiki_user.;
grant create table to &wiki_wiki_user.;
grant create sequence to &wiki_wiki_user.;
grant create trigger to &wiki_wiki_user.;
