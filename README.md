zDbSession
==========

Note: using a mapper for sessions may cause anxiety attacks, panic and
chaos. I did it and I confirm the symptoms. You should probably use the raw
dbal connection
…

On 7 Jun 2013 00:05, "Tim Roediger" <notifications@github.com> wrote:
 It can be done. As @bakura10 <https://github.com/bakura10> said, just
 write a new storage class and specify it in the config. However, you may
 want to avoid using doctrine itself to persist to the db. If you do, you
 can't use anything in the session until after doctrine has bootstrapped,
 which is normally later than you might want in the zf2 request handling
 process.

 —
 Reply to this email directly or view it on GitHub<https://github.com/doctrine/DoctrineModule/issues/270#issuecomment-19077445>
 
 After many hours of trying to get this to work properly I finally gave up, as mentioned above the main issue that exists
 is "you can't use anything in the session until after doctrine has bootstrapped" which is rather annoying issue to get
 by.  I will leave the module up for educational purposes only but my other DBSessionStorage module should be used in
 place of this one.
 
 Link for DBSessionStorage is here: https://github.com/Nitecon/DBSessionStorage
