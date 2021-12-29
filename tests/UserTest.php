<?php


use App\Entity\User;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
        $this->user->setFirstname('Antoine');
        $this->user->setLastname('Saunier');
        $this->user->setMail('antoine.saunier@test.fr');
        $this->user->setPassword('password');
        $dateInfo = explode("/",'2000/08/23') ;
        $this->user->setBirthdate(Carbon::create( $dateInfo[0], $dateInfo[1], $dateInfo[2],0,0,0,"Europe/Paris") );
        parent::setUp();
    }

    public function testIsValidNominal()
    {
        $this->assertTrue($this->user->isValid());
    }

    public function testNotValidDueToEmptyFirstname()
    {
        $this->user->setFirstname('');
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToEmptyLastname()
    {
        $this->user->setLastname('');
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToEmptyPassword()
    {
        $this->user->setPassword('');
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToPasswordToShort()
    {
        $this->user->setPassword('Test');
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToPasswordToLong()
    {
        $this->user->setPassword('12345678901234567890123456789012345678901234567890');
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToBirthdayInFuture()
    {
        $this->user->setBirthdate(Carbon::now()->addDecade());
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToTooYoungUser()
    {
        $this->user->setBirthdate(Carbon::now()->subDecade());
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToEmptyBirthdate()
    {
        $this->user->setBirthdate(Carbon::create( '', '', '',0,0,0,"Europe/Paris") );
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToEmptyEmail()
    {
        $this->user->setMail('');
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToBadEmail()
    {
        $this->user->setMail('toto');
        $this->assertFalse($this->user->isValid());
    }
}