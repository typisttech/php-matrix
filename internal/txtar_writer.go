package internal

import (
	"os"
	"path/filepath"
)

type txtarWriter interface {
	Name() string
	Write(f *os.File) error
}

func Generate[T txtarWriter](name string, cases ...T) error {
	os.Stdout.WriteString("\n==> Generating " + name + " scripts\n\n")

	dir, err := filepath.Abs("testdata")
	if err != nil {
		return err
	}
	os.Stdout.WriteString(dir + "\n")

	if err := ensureDirEmpty(dir); err != nil {
		return err
	}

	for _, w := range cases {
		n := sanitizeFilename(w.Name()) + ".txtar"
		os.Stdout.WriteString("  - " + n + "\n")

		r, err := os.OpenRoot(dir)
		if err != nil {
			return err
		}
		defer r.Close()

		f, err := r.Create(n)
		if err != nil {
			return err
		}
		defer f.Close()

		err = w.Write(f)
		if err != nil {
			return err
		}
	}

	return nil
}
