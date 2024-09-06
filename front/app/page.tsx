import JobCard from '../components/JobCard';

export default async function Home() {
    let data = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/jobs`, {next: { revalidate: 1 }});
    let jobs = await data.json();

    return (
        <div className="flex flex-wrap justify-center">
            {jobs.map((job) => (
                <JobCard
                    id={job.id}
                    title={job.title}
                    description={job.description}
                    createdAt={job.createdAt}
                />
            ))}
        </div>
    );
}
