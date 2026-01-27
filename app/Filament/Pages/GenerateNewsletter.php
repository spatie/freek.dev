<?php

namespace App\Filament\Pages;

use App\Actions\GenerateNewsletterAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class GenerateNewsletter extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.generate-newsletter';

    public ?int $generatedEditionNumber = null;

    public ?string $generatedStartDate = null;

    public ?string $generatedEndDate = null;

    public ?string $generatedMailcoachUrl = null;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Newsletter')
                ->requiresConfirmation()
                ->modalHeading('Generate Newsletter')
                ->modalDescription('This will create a new newsletter campaign in Mailcoach with all posts since the last newsletter.')
                ->modalSubmitActionLabel('Generate')
                ->action(function (): void {
                    try {
                        $result = (new GenerateNewsletterAction())->execute();

                        $this->generatedEditionNumber = $result->editionNumber;
                        $this->generatedStartDate = $result->startDate->format('M j, Y');
                        $this->generatedEndDate = $result->endDate->format('M j, Y');
                        $this->generatedMailcoachUrl = $result->getMailcoachUrl();

                        Notification::make()
                            ->title("Newsletter #{$result->editionNumber} created")
                            ->success()
                            ->actions([
                                Action::make('open')
                                    ->label('Open in Mailcoach')
                                    ->url($this->generatedMailcoachUrl, shouldOpenInNewTab: true)
                                    ->button(),
                            ])
                            ->persistent()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Failed to generate newsletter')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
