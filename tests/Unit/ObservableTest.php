<?php

use Dada\AutoClassHelper\Dev\Models\DoesntHave;
use Dada\AutoClassHelper\Dev\Models\Test;

it('Observer Class Exist', closure: function () {
    $data=accessPrivateOrProtected(new Test(),'hasObserver');
    $class=\Dada\AutoClassHelper\Dev\Observers\TestObserver::class;
    $val=Test::bootObservable();
    expect($data)->toBe($class)->and($val)->toBeTrue();
});

it('Observer Class Doesn\'t Exists', closure: function () {
    $data=accessPrivateOrProtected(new DoesntHave(),'hasObserver');
    $val=DoesntHave::bootObservable();
    expect($data)->toBeFalse()->and($val)->toBeFalse();
});

