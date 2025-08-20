import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Calendar, MapPin, Clock, Plus, Trophy, Users, Target } from 'lucide-react';
import { Link } from '@inertiajs/react';

interface Team {
    id: number;
    name: string;
    code: string;
}

interface Group {
    id: number;
    name: string;
    stage: number;
}

interface Match {
    id: number;
    home_team: Team;
    away_team: Team;
    match_date: string;
    venue: string;
    referee: string | null;
    home_score: number | null;
    away_score: number | null;
    status: string;
    stage: string;
    group: Group | null;
}

interface PaginatedMatches {
    data: Match[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    matches: PaginatedMatches;
    [key: string]: unknown;
}

export default function MatchesIndex({ matches }: Props) {
    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'completed':
                return 'default';
            case 'in_progress':
                return 'destructive';
            case 'scheduled':
                return 'secondary';
            case 'postponed':
                return 'outline';
            default:
                return 'outline';
        }
    };

    const getStageIcon = (stage: string) => {
        switch (stage) {
            case 'group_stage_1':
            case 'group_stage_2':
                return <Users className="h-4 w-4" />;
            case 'quarterfinals':
            case 'semifinals':
                return <Target className="h-4 w-4" />;
            case 'final':
                return <Trophy className="h-4 w-4" />;
            default:
                return <Calendar className="h-4 w-4" />;
        }
    };

    const formatStage = (stage: string) => {
        return stage.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
    };

    return (
        <AppShell>
            <div className="container mx-auto px-4 py-8">
                <div className="flex justify-between items-center mb-8">
                    <div>
                        <h1 className="text-3xl font-bold flex items-center gap-2">
                            <Calendar className="h-8 w-8" />
                            Match Schedule
                        </h1>
                        <p className="text-muted-foreground mt-2">
                            View all tournament matches and results
                        </p>
                    </div>
                    <Link href={route('matches.create')}>
                        <Button>
                            <Plus className="mr-2 h-4 w-4" />
                            Add Match
                        </Button>
                    </Link>
                </div>

                {matches.data.length > 0 ? (
                    <>
                        <div className="space-y-4">
                            {matches.data.map((match) => (
                                <Card key={match.id} className="hover:shadow-lg transition-shadow">
                                    <CardContent className="p-6">
                                        <div className="flex items-center justify-between">
                                            <div className="flex-1">
                                                <div className="flex items-center gap-4 mb-3">
                                                    <Badge variant="outline" className="flex items-center gap-1">
                                                        {getStageIcon(match.stage)}
                                                        {formatStage(match.stage)}
                                                    </Badge>
                                                    {match.group && (
                                                        <Badge variant="secondary">
                                                            {match.group.name} - Stage {match.group.stage}
                                                        </Badge>
                                                    )}
                                                    <Badge variant={getStatusColor(match.status)}>
                                                        {match.status.toUpperCase()}
                                                    </Badge>
                                                </div>
                                                
                                                <div className="grid md:grid-cols-3 gap-4 items-center">
                                                    {/* Teams and Score */}
                                                    <div className="md:col-span-2">
                                                        <div className="flex items-center justify-between">
                                                            <div className="flex items-center gap-3">
                                                                <div className="text-right">
                                                                    <div className="font-semibold">{match.home_team.name}</div>
                                                                    <div className="text-sm text-muted-foreground">{match.home_team.code}</div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div className="px-4">
                                                                {match.home_score !== null ? (
                                                                    <div className="text-2xl font-bold text-center">
                                                                        {match.home_score} - {match.away_score}
                                                                    </div>
                                                                ) : (
                                                                    <div className="text-lg text-muted-foreground">
                                                                        vs
                                                                    </div>
                                                                )}
                                                            </div>
                                                            
                                                            <div className="flex items-center gap-3">
                                                                <div>
                                                                    <div className="font-semibold">{match.away_team.name}</div>
                                                                    <div className="text-sm text-muted-foreground">{match.away_team.code}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    {/* Match Details */}
                                                    <div className="space-y-2">
                                                        <div className="flex items-center gap-2 text-sm">
                                                            <Clock className="h-4 w-4 text-muted-foreground" />
                                                            {formatDate(match.match_date)}
                                                        </div>
                                                        <div className="flex items-center gap-2 text-sm">
                                                            <MapPin className="h-4 w-4 text-muted-foreground" />
                                                            {match.venue}
                                                        </div>
                                                        {match.referee && (
                                                            <div className="text-sm text-muted-foreground">
                                                                Ref: {match.referee}
                                                            </div>
                                                        )}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div className="ml-4">
                                                <Link href={route('matches.show', match.id)}>
                                                    <Button variant="outline" size="sm">
                                                        View Details
                                                    </Button>
                                                </Link>
                                            </div>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>

                        {matches.last_page > 1 && (
                            <div className="flex justify-center mt-8">
                                <div className="flex gap-2">
                                    {Array.from({ length: matches.last_page }, (_, i) => i + 1).map((page) => (
                                        <Link key={page} href={`?page=${page}`}>
                                            <Button 
                                                variant={page === matches.current_page ? "default" : "outline"}
                                                size="sm"
                                            >
                                                {page}
                                            </Button>
                                        </Link>
                                    ))}
                                </div>
                            </div>
                        )}
                    </>
                ) : (
                    <Card>
                        <CardContent className="text-center py-12">
                            <Calendar className="h-16 w-16 mx-auto mb-4 text-muted-foreground" />
                            <h3 className="text-xl font-semibold mb-2">No Matches Found</h3>
                            <p className="text-muted-foreground mb-6">
                                Get started by scheduling tournament matches.
                            </p>
                            <Link href={route('matches.create')}>
                                <Button>
                                    <Plus className="mr-2 h-4 w-4" />
                                    Schedule Your First Match
                                </Button>
                            </Link>
                        </CardContent>
                    </Card>
                )}
            </div>
        </AppShell>
    );
}