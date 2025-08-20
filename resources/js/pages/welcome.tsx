import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Calendar, Trophy, Users, MapPin, Clock, Target } from 'lucide-react';

interface Team {
    id: number;
    name: string;
    code: string;
    logo: string | null;
}

interface GroupTeam {
    id: number;
    team: Team;
    points: number;
    matches_played: number;
    wins: number;
    draws: number;
    losses: number;
    goals_for: number;
    goals_against: number;
    goal_difference: number;
}

interface Group {
    id: number;
    name: string;
    stage: number;
    group_teams: GroupTeam[];
}

interface Match {
    id: number;
    home_team: Team;
    away_team: Team;
    match_date: string;
    venue: string;
    status: string;
    stage: string;
    home_score: number | null;
    away_score: number | null;
    group: Group | null;
}

interface Tournament {
    id: number;
    name: string;
    description: string | null;
    start_date: string;
    end_date: string;
    status: string;
}

interface Props {
    tournament: Tournament | null;
    groups: Group[];
    upcomingMatches: Match[];
    playoffMatches: Match[];
    [key: string]: unknown;
}

export default function Welcome({ tournament, groups, upcomingMatches, playoffMatches }: Props) {
    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
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

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'completed':
                return 'default';
            case 'in_progress':
                return 'destructive';
            case 'scheduled':
                return 'secondary';
            default:
                return 'outline';
        }
    };

    if (!tournament) {
        return (
            <AppShell>
                <div className="container mx-auto px-4 py-8 text-center">
                    <div className="max-w-4xl mx-auto">
                        <div className="mb-8">
                            <h1 className="text-6xl font-bold mb-4">⚽ Tournament Manager</h1>
                            <p className="text-xl text-muted-foreground mb-8">
                                Professional football tournament management system with group stages and playoffs
                            </p>
                        </div>

                        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                            <Card className="text-center">
                                <CardHeader>
                                    <Users className="h-8 w-8 mx-auto mb-2 text-primary" />
                                    <CardTitle className="text-lg">Team Management</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-sm text-muted-foreground">
                                        Manage teams, logos, and player information
                                    </p>
                                </CardContent>
                            </Card>

                            <Card className="text-center">
                                <CardHeader>
                                    <Trophy className="h-8 w-8 mx-auto mb-2 text-primary" />
                                    <CardTitle className="text-lg">Tournament Stages</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-sm text-muted-foreground">
                                        Two group stages followed by playoff brackets
                                    </p>
                                </CardContent>
                            </Card>

                            <Card className="text-center">
                                <CardHeader>
                                    <Calendar className="h-8 w-8 mx-auto mb-2 text-primary" />
                                    <CardTitle className="text-lg">Match Scheduling</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-sm text-muted-foreground">
                                        Schedule matches with venues, dates, and referees
                                    </p>
                                </CardContent>
                            </Card>

                            <Card className="text-center">
                                <CardHeader>
                                    <Target className="h-8 w-8 mx-auto mb-2 text-primary" />
                                    <CardTitle className="text-lg">Live Standings</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-sm text-muted-foreground">
                                        Real-time league tables and playoff brackets
                                    </p>
                                </CardContent>
                            </Card>
                        </div>

                        <Card className="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950 dark:to-indigo-950">
                            <CardHeader>
                                <CardTitle className="text-2xl">Ready to Get Started?</CardTitle>
                                <CardDescription className="text-lg">
                                    No tournament data found. Administrators can set up teams and matches to get started.
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div className="flex gap-4 justify-center">
                                    <Button size="lg">
                                        <Users className="mr-2 h-4 w-4" />
                                        View Teams
                                    </Button>
                                    <Button variant="outline" size="lg">
                                        <Calendar className="mr-2 h-4 w-4" />
                                        View Schedule
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </AppShell>
        );
    }

    return (
        <AppShell>
            <div className="container mx-auto px-4 py-8">
                {/* Tournament Header */}
                <div className="text-center mb-8">
                    <h1 className="text-4xl font-bold mb-2">⚽ {tournament.name}</h1>
                    {tournament.description && (
                        <p className="text-lg text-muted-foreground mb-4">{tournament.description}</p>
                    )}
                    <div className="flex justify-center items-center gap-4 text-sm text-muted-foreground">
                        <span>{new Date(tournament.start_date).toLocaleDateString()} - {new Date(tournament.end_date).toLocaleDateString()}</span>
                        <Badge variant={tournament.status === 'completed' ? 'default' : 'secondary'}>
                            {tournament.status.replace('_', ' ').toUpperCase()}
                        </Badge>
                    </div>
                </div>

                <div className="grid lg:grid-cols-3 gap-8">
                    {/* Group Stage Tables */}
                    <div className="lg:col-span-2">
                        <h2 className="text-2xl font-bold mb-6">🏆 Group Stage Tables</h2>
                        
                        {groups.length > 0 ? (
                            <div className="grid md:grid-cols-2 gap-6">
                                {groups.map((group) => (
                                    <Card key={group.id}>
                                        <CardHeader>
                                            <CardTitle className="flex items-center gap-2">
                                                <Trophy className="h-5 w-5" />
                                                {group.name} - Stage {group.stage}
                                            </CardTitle>
                                        </CardHeader>
                                        <CardContent>
                                            <div className="space-y-2">
                                                {group.group_teams.map((groupTeam, index) => (
                                                    <div key={groupTeam.id} className={`flex items-center justify-between p-3 rounded-lg ${index < 2 ? 'bg-green-50 dark:bg-green-950' : 'bg-muted'}`}>
                                                        <div className="flex items-center gap-3">
                                                            <span className="font-mono text-sm w-6">{index + 1}.</span>
                                                            <div>
                                                                <div className="font-medium">{groupTeam.team.name}</div>
                                                                <div className="text-xs text-muted-foreground">
                                                                    {groupTeam.wins}W {groupTeam.draws}D {groupTeam.losses}L
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="text-right">
                                                            <div className="font-bold">{groupTeam.points} pts</div>
                                                            <div className="text-xs text-muted-foreground">
                                                                {groupTeam.goals_for}:{groupTeam.goals_against} ({groupTeam.goal_difference > 0 ? '+' : ''}{groupTeam.goal_difference})
                                                            </div>
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>
                                        </CardContent>
                                    </Card>
                                ))}
                            </div>
                        ) : (
                            <Card>
                                <CardContent className="text-center py-8">
                                    <Trophy className="h-12 w-12 mx-auto mb-4 text-muted-foreground" />
                                    <p className="text-muted-foreground">No group stage data available yet.</p>
                                </CardContent>
                            </Card>
                        )}

                        {/* Playoff Bracket */}
                        {playoffMatches.length > 0 && (
                            <div className="mt-8">
                                <h2 className="text-2xl font-bold mb-6">🎯 Playoff Bracket</h2>
                                <Card>
                                    <CardContent className="p-6">
                                        <div className="space-y-4">
                                            {['quarterfinals', 'semifinals', 'final'].map((stage) => {
                                                const stageMatches = playoffMatches.filter(match => match.stage === stage);
                                                if (stageMatches.length === 0) return null;

                                                return (
                                                    <div key={stage}>
                                                        <h3 className="font-semibold mb-3 capitalize flex items-center gap-2">
                                                            {getStageIcon(stage)}
                                                            {stage}
                                                        </h3>
                                                        <div className="grid gap-3">
                                                            {stageMatches.map((match) => (
                                                                <div key={match.id} className="flex items-center justify-between p-3 border rounded-lg">
                                                                    <div className="flex items-center gap-4">
                                                                        <div className="text-sm">
                                                                            <div>{match.home_team.name}</div>
                                                                            <div className="text-muted-foreground">vs</div>
                                                                            <div>{match.away_team.name}</div>
                                                                        </div>
                                                                        {match.home_score !== null && (
                                                                            <div className="text-lg font-bold">
                                                                                {match.home_score} - {match.away_score}
                                                                            </div>
                                                                        )}
                                                                    </div>
                                                                    <div className="text-right text-sm">
                                                                        <Badge variant={getStatusColor(match.status)}>
                                                                            {match.status}
                                                                        </Badge>
                                                                        <div className="text-muted-foreground mt-1">
                                                                            {formatDate(match.match_date)}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            ))}
                                                        </div>
                                                    </div>
                                                );
                                            })}
                                        </div>
                                    </CardContent>
                                </Card>
                            </div>
                        )}
                    </div>

                    {/* Sidebar */}
                    <div>
                        {/* Upcoming Matches */}
                        <Card className="mb-6">
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2">
                                    <Calendar className="h-5 w-5" />
                                    Upcoming Matches
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                {upcomingMatches.length > 0 ? (
                                    <div className="space-y-4">
                                        {upcomingMatches.slice(0, 5).map((match) => (
                                            <div key={match.id} className="border-l-4 border-primary pl-4">
                                                <div className="font-medium text-sm">
                                                    {match.home_team.name} vs {match.away_team.name}
                                                </div>
                                                <div className="text-xs text-muted-foreground flex items-center gap-2 mt-1">
                                                    <Clock className="h-3 w-3" />
                                                    {formatDate(match.match_date)}
                                                </div>
                                                <div className="text-xs text-muted-foreground flex items-center gap-2">
                                                    <MapPin className="h-3 w-3" />
                                                    {match.venue}
                                                </div>
                                                {match.group && (
                                                    <Badge variant="outline" className="text-xs mt-2">
                                                        {match.group.name}
                                                    </Badge>
                                                )}
                                            </div>
                                        ))}
                                        {upcomingMatches.length > 5 && (
                                            <Button variant="outline" size="sm" className="w-full">
                                                View All Matches
                                            </Button>
                                        )}
                                    </div>
                                ) : (
                                    <p className="text-sm text-muted-foreground">No upcoming matches scheduled.</p>
                                )}
                            </CardContent>
                        </Card>

                        {/* Quick Actions */}
                        <Card>
                            <CardHeader>
                                <CardTitle>Quick Actions</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-2">
                                    <Button variant="outline" className="w-full justify-start">
                                        <Users className="mr-2 h-4 w-4" />
                                        View All Teams
                                    </Button>
                                    <Button variant="outline" className="w-full justify-start">
                                        <Calendar className="mr-2 h-4 w-4" />
                                        Full Schedule
                                    </Button>
                                    <Button variant="outline" className="w-full justify-start">
                                        <Trophy className="mr-2 h-4 w-4" />
                                        Tournament Stats
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}