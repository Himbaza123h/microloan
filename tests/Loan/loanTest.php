<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create sample loans with different statuses
        Loan::factory()->create(['status' => 'approved']);
        Loan::factory()->create(['status' => 'pending']);
        Loan::factory()->create(['status' => 'approved']);
        Loan::factory()->create(['status' => 'rejected']);
    }

    public function testGetApprovedLoans()
    {
        $loanapproved = Loan::where('status', 'approved')->get();

        $this->assertEquals(2, $loanapproved->count());
        $this->assertTrue($loanapproved->every(fn($loan) => $loan->status === 'approved'));
    }

    public function testApprovedLoansAttributes()
    {
        $loanapproved = Loan::where('status', 'approved')->first();

        $this->assertNotNull($loanapproved);
        $this->assertInstanceOf(Loan::class, $loanapproved);
        $this->assertEquals('approved', $loanapproved->status);
    }
}
