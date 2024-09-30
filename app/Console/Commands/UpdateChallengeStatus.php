namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Challenge;
use Carbon\Carbon;

class UpdateChallengeStatus extends Command
{
    protected $signature = 'challenge:update-status';
    protected $description = 'Update the status of challenges based on end date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentDate = Carbon::now();

        // Find all challenges where the end date has passed and the status is still open
        $challenges = Challenge::where('end_date', '<', $currentDate)
            ->where('status', 'open')
            ->get();

        foreach ($challenges as $challenge) {
            $challenge->status = 'closed';
            $challenge->save();
        }

        // Optionally, you can also reopen challenges where the current date is before the end date
        $reopenChallenges = Challenge::where('end_date', '>', $currentDate)
            ->where('status', 'closed')
            ->get();

        foreach ($reopenChallenges as $challenge) {
            $challenge->status = 'open';
            $challenge->save();
        }

        $this->info('Challenge statuses updated successfully.');
    }
}
