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
	os.Stdout.Write([]byte("\n==> Generating " + name + " scripts\n\n"))

	dir, err := filepath.Abs("testdata")
	if err != nil {
		return err
	}
	os.Stdout.Write([]byte(dir + "\n"))

	if err := ensureDirEmpty(dir); err != nil {
		return err
	}

	for _, w := range cases {
		n := sanitizeFilename(w.Name()) + ".txtar"
		os.Stdout.Write([]byte("  - " + n + "\n"))

		p := filepath.Join(dir, n)
		f, err := os.Create(p)
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
