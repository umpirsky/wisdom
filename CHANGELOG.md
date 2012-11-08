CHANGELOG
=========

* 0.1.0 (2012-11-08)

  * Changed to promise-based API

    Before:

        $wisdom->check($domains, function ($domain, $available) {
            printf('Domain %s is %s.%s', $domain, $available ? 'available' : 'taken', PHP_EOL);
        });

    After:

        $domain = 'igor.io';
        $wisdom
            ->check($domain)
            ->then(function ($available) use ($domain) {
                printf('Domain %s is %s.%s', $domain, $available ? 'available' : 'taken', PHP_EOL);
            });

        $domains = array('igor.io', 'igor-wut.io');
        $wisdom
            ->checkAll($domains)
            ->then(function ($statuses) {
                foreach ($statuses as $domain => $available) {
                    printf('Domain %s is %s.%s', $domain, $available ? 'available' : 'taken', PHP_EOL);
                }
            });
