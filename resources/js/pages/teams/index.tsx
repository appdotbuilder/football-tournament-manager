import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Users, Plus, Edit, Eye } from 'lucide-react';
import { Link } from '@inertiajs/react';

interface Team {
    id: number;
    name: string;
    code: string;
    logo: string | null;
    description: string | null;
    created_at: string;
}

interface PaginatedTeams {
    data: Team[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    teams: PaginatedTeams;
    [key: string]: unknown;
}

export default function TeamsIndex({ teams }: Props) {
    return (
        <AppShell>
            <div className="container mx-auto px-4 py-8">
                <div className="flex justify-between items-center mb-8">
                    <div>
                        <h1 className="text-3xl font-bold flex items-center gap-2">
                            <Users className="h-8 w-8" />
                            Teams
                        </h1>
                        <p className="text-muted-foreground mt-2">
                            Manage tournament teams and view their performance
                        </p>
                    </div>
                    <Link href={route('teams.create')}>
                        <Button>
                            <Plus className="mr-2 h-4 w-4" />
                            Add Team
                        </Button>
                    </Link>
                </div>

                {teams.data.length > 0 ? (
                    <>
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            {teams.data.map((team) => (
                                <Card key={team.id} className="hover:shadow-lg transition-shadow">
                                    <CardHeader className="pb-3">
                                        <div className="flex items-center justify-between">
                                            <Badge variant="secondary">{team.code}</Badge>
                                            <div className="flex gap-1">
                                                <Link href={route('teams.show', team.id)}>
                                                    <Button variant="ghost" size="sm">
                                                        <Eye className="h-4 w-4" />
                                                    </Button>
                                                </Link>
                                                <Link href={route('teams.edit', team.id)}>
                                                    <Button variant="ghost" size="sm">
                                                        <Edit className="h-4 w-4" />
                                                    </Button>
                                                </Link>
                                            </div>
                                        </div>
                                        <CardTitle className="text-lg">{team.name}</CardTitle>
                                    </CardHeader>
                                    <CardContent>
                                        {team.logo ? (
                                            <div className="w-16 h-16 mx-auto mb-3 bg-muted rounded-lg flex items-center justify-center">
                                                <img 
                                                    src={`/storage/${team.logo}`} 
                                                    alt={`${team.name} logo`}
                                                    className="w-full h-full object-contain rounded-lg"
                                                />
                                            </div>
                                        ) : (
                                            <div className="w-16 h-16 mx-auto mb-3 bg-muted rounded-lg flex items-center justify-center">
                                                <Users className="h-8 w-8 text-muted-foreground" />
                                            </div>
                                        )}
                                        {team.description && (
                                            <p className="text-sm text-muted-foreground line-clamp-2">
                                                {team.description}
                                            </p>
                                        )}
                                        <div className="mt-3 pt-3 border-t">
                                            <p className="text-xs text-muted-foreground">
                                                Added {new Date(team.created_at).toLocaleDateString()}
                                            </p>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>

                        {teams.last_page > 1 && (
                            <div className="flex justify-center mt-8">
                                <div className="flex gap-2">
                                    {Array.from({ length: teams.last_page }, (_, i) => i + 1).map((page) => (
                                        <Link key={page} href={`?page=${page}`}>
                                            <Button 
                                                variant={page === teams.current_page ? "default" : "outline"}
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
                            <Users className="h-16 w-16 mx-auto mb-4 text-muted-foreground" />
                            <h3 className="text-xl font-semibold mb-2">No Teams Found</h3>
                            <p className="text-muted-foreground mb-6">
                                Get started by adding teams to the tournament.
                            </p>
                            <Link href={route('teams.create')}>
                                <Button>
                                    <Plus className="mr-2 h-4 w-4" />
                                    Add Your First Team
                                </Button>
                            </Link>
                        </CardContent>
                    </Card>
                )}
            </div>
        </AppShell>
    );
}