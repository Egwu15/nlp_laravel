import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

function ViewSections({ sections, part, chapter, law }) {
    console.log(sections);
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    <p>Law - {law.title}</p>
                    <p>Chapter - {chapter.title}</p>
                    <p>Part - {part.title}</p>
                </h2>
            }
        >
            <Head title={`Sections - ${part.title}`} />
            <div className="max-w-screen-md mt-3 mx-auto px-4 text-black">
                {sections.map((section) => (
                    <div className="bg-white/95 card shadow-sm mb-2 p-3"
                        key={section.id}
                    >
                        <p className="font-bold text-lg">
                            Section {section.number}
                        </p>
                        <p style={{ whiteSpace: "pre-wrap" }}>
                            {section.content}
                        </p>
                    </div>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}

export default ViewSections;
